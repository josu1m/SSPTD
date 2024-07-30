<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de abarrotes</title>
    <style>
        :root {
            padding: 0;
            margin: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
    </style>
    @stack('css')

</head>

<body>
    @include('venta.components.indice')
    @include('venta.components.venta')
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

    @include('venta.components.cliente')
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

    @include('venta.components.proveedor')
    {{-- @include('venta.components.producto') --}}
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    @include('venta.components.productodisponible')





</body>

</html>
