<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            ['name' => 'Alemania', 'value' => 16],
            ['name' => 'Inglaterra', 'value' => 22],
            ['name' => 'Escocia', 'value' => 15],
            ['name' => 'Francia', 'value' => 23],
            ['name' => 'Grecia', 'value' => 18],
            ['name' => 'Italia', 'value' => 37],
            ['name' => 'Portugal', 'value' => 10],
            ['name' => 'Rusia', 'value' => 17],
            ['name' => 'Perú', 'value' => 45],

        ];

        $colors = $this->getOrGenerateUniqueColors(array_column($data, 'name'));

        $chartConfig = [
            'title' => 'Obesidad y Sobrepeso',
            'yAxisLabel' => 'Tasa por ciento',
            'xAxisLabel' => 'Países',
            'data' => $data,
            'colors' => $colors,
            'width' => '100%',
            'height' => '400px',
        ];

        return view('prueba.index', compact('chartConfig'));
    }

    private function getOrGenerateUniqueColors($countries)
    {
        $colorFile = storage_path('app/unique_chart_colors.json');

        if (file_exists($colorFile)) {
            $savedColors = json_decode(file_get_contents($colorFile), true);
        } else {
            $savedColors = [];
        }

        $colors = [];
        $newColors = false;

        foreach ($countries as $country) {
            if (!isset($savedColors[$country])) {
                $color = $this->generateUniqueColor($savedColors);
                $savedColors[$country] = $color;
                $newColors = true;
            }
            $colors[] = $savedColors[$country];
        }

        if ($newColors) {
            file_put_contents($colorFile, json_encode($savedColors));
        }

        return $colors;
    }

    private function generateUniqueColor($existingColors)
    {
        do {
            $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        } while (in_array($color, $existingColors));

        return $color;
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
