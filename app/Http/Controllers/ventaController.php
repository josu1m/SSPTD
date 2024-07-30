<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Proveedore;
use App\Models\Venta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class ventaController extends Controller
{
    private function obtenerDatosProductoDisponible()
    {
        $productos = Producto::with(['categorias.caracteristica', 'marca.caracteristica', 'presentacione.caracteristica'])->latest()->get();

        return $productos->map(function ($producto) {
            return [
                'nombre' => $producto->nombre,
                'stock' => $producto->stock,
                'fecha_vencimiento'=>$producto->fecha_vencimiento
            ];
        });
    }


    public function ventaPdf()
    {


        $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
            ->where('estado', 1)
            ->latest()
            ->get();
        $totalVentas = $ventas->count();
        $clientes = Cliente::with('persona.documento')->get();
        $totalClientes = $clientes->count();

        $proveedores = Proveedore::with('persona.documento')->get();
        $totalProveedor = $proveedores->count();
        $productos = Producto::with(['categorias.caracteristica', 'marca.caracteristica', 'presentacione.caracteristica'])->latest()->get();
        $totalProducto = $productos->count();
        $totalStock = $productos->sum('stock');


        $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
            ->where('estado', 1)
            ->latest()
            ->get();

        // Agrupar ventas por fecha
        $datosPorFecha = $ventas->groupBy(function ($venta) {
            return $venta->created_at->format('Y-m-d');
        });
        // Procesar datos para la tabla
        $datosTabla = $datosPorFecha->map(function ($ventasPorFecha) {
            return [
                'fecha' => $ventasPorFecha->first()->created_at->format('Y-m-d'),
                'total_ventas' => $ventasPorFecha->count(),
                'vendedores' => $ventasPorFecha->groupBy('user.name')
                    ->map(function ($ventasVendedor) {
                        return [
                            'nombre_vendedor' => $ventasVendedor->first()->user->name,
                            'total_ventas' => $ventasVendedor->count(),
                        ];
                    })->values(),
            ];
        })->values();
        $datosProductos = $this->obtenerDatosProductoDisponible();



        $pdf = Pdf::loadView('venta.pdf', compact('ventas', 'totalVentas', 'clientes', 'totalClientes', 'proveedores', 'totalProveedor', 'productos', 'totalProducto', 'datosTabla', 'datosProductos','totalStock'));
        return $pdf->stream('ventas.pdf');
    }
    function __construct()
    {
        $this->middleware('permission:ver-venta|crear-venta|mostrar-venta|eliminar-venta', ['only' => ['index']]);
        $this->middleware('permission:crear-venta', ['only' => ['create', 'store']]);
        $this->middleware('permission:mostrar-venta', ['only' => ['show']]);
        $this->middleware('permission:eliminar-venta', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
            ->where('estado', 1)
            ->latest()
            ->get();

        return view('venta.index', compact('ventas'));
    }

    public function reporteVentas()
    {
        $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
            ->where('estado', 1)
            ->latest()
            ->get();

        $datosGrafico = $ventas->groupBy(function ($venta) {
            return $venta->created_at->format('Y-m-d');
        })->map(function ($grupo) {
            return [
                'count' => $grupo->count(),
                'vendedores' => $grupo->groupBy('user.name')
                    ->map(function ($ventasVendedor) {
                        return $ventasVendedor->count();
                    })
            ];
        });


        return view('venta.reporte', compact('datosGrafico'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $subquery = DB::table('compra_producto')
            ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
            ->groupBy('producto_id');

        $productos = Producto::join('compra_producto as cpr', function ($join) use ($subquery) {
            $join->on('cpr.producto_id', '=', 'productos.id')
                ->whereIn('cpr.created_at', function ($query) use ($subquery) {
                    $query->select('max_created_at')
                        ->fromSub($subquery, 'subquery')
                        ->whereRaw('subquery.producto_id = cpr.producto_id');
                });
        })
            ->select('productos.nombre', 'productos.id', 'productos.stock', 'cpr.precio_venta')
            ->where('productos.estado', 1)
            ->where('productos.stock', '>', 0)
            ->get();

        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();
        $comprobantes = Comprobante::all();

        return view('venta.create', compact('productos', 'clientes', 'comprobantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
        try {
            DB::beginTransaction();

            //Llenar mi tabla venta
            $venta = Venta::create($request->validated());

            //Llenar mi tabla venta_producto
            //1. Recuperar los arrays
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $arrayDescuento = $request->get('arraydescuento');

            //2.Realizar el llenado
            $siseArray = count($arrayProducto_id);
            $cont = 0;

            while ($cont < $siseArray) {
                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                        'descuento' => $arrayDescuento[$cont]
                    ]
                ]);

                //Actualizar stock
                $producto = Producto::find($arrayProducto_id[$cont]);
                $stockActual = $producto->stock;
                $cantidad = intval($arrayCantidad[$cont]);

                DB::table('productos')
                    ->where('id', $producto->id)
                    ->update([
                        'stock' => $stockActual - $cantidad
                    ]);

                $cont++;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('ventas.index')->with('success', 'Venta exitosa');
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        return view('venta.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Venta::where('id', $id)
            ->update([
                'estado' => 0
            ]);

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada');
    }
}
