<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        $compras = Compra::with('comprobante', 'proveedore.persona')
        ->where('estado', 1)
        ->latest()
        ->get();

    $datosGrafico1 = $compras->groupBy(function($compra) {
            return Carbon::parse($compra->created_at)->format('Y-m-d');
        })
        ->map(function ($grupo) {
            return [
                'count' => $grupo->count(),
                'proveedores' => $grupo->groupBy('proveedore.persona.nombre')
                    ->map->count()
            ];
        });

        return view('prueba.index', compact('datosGrafico','datosGrafico1'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
