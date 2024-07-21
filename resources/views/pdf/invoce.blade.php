<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Productos Avanzada</title>
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
    @include('pdf.components.indice')
    @include('pdf.components.venta')
    @include('pdf.components.tabla')


</body>

</html>
