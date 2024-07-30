<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function index()
    {
        // VENTAS
        $datosGrafico = $this->obtenerDatosVentaGrafico();
        $datosClientes = $this->obtenerDatosClienteGrafico();
        $datosProducto = $this->obtenerDatosProductoDisponibleGrafico();


        // CLIENTES
        // PRODUCTO
        if (!Auth::check()) {
            return view('welcome');
        }

        return view('panel.index', compact('datosGrafico', 'datosClientes', 'datosProducto'));
    }
    private function obtenerDatosVentaGrafico()
    {
        $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
            ->where('estado', 1)
            ->latest()
            ->get();

        return $ventas->groupBy(function ($venta) {
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
    }
    private function obtenerDatosClienteGrafico()
    {

        $clientes = Cliente::with('persona.documento')
            ->whereNotNull('created_at')
            ->get();

        return $clientes->groupBy(function ($cliente) {
            return $cliente->created_at->startOfWeek()->format('Y-W');
        })->map(function ($grupo, $semana) {
            list($año, $numSemana) = explode('-', $semana);
            $numSemana = max(1, min(53, (int)$numSemana));
            $fecha = Carbon::now()->setISODate($año, $numSemana);

            return [
                'x' => $fecha->timestamp * 1000,
                'y' => $grupo->count(),
                'week' => $fecha->format('W, Y'),
                'drilldown' => $grupo->groupBy(function ($cliente) {
                    return $cliente->persona->documento->tipo ?? 'Desconocido';
                })->map(function ($subgrupo, $tipo) {
                    return [
                        'name' => $tipo,
                        'y' => $subgrupo->count()
                    ];
                })->values()->toArray()
            ];
        })->values();
    }
    private function obtenerDatosProductoDisponibleGrafico()
    {
        $productos = Producto::with(['categorias.caracteristica', 'marca.caracteristica', 'presentacione.caracteristica'])->latest()->get();

        return $productos->map(function ($producto) {
            return [
                'name' => $producto->nombre,
                'y' => $producto->stock,
            ];
        });
    }
    private function obtenerDatosProductoNoDisponibleGrafico()
    {

    }
}
