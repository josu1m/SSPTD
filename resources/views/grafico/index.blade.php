<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas por Día</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <style>
        .contenedor {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .grafico {
            width: 45%;
            min-width: 300px;
            height: 400px;
            margin-bottom: 20px;
        }

        @media screen and (max-width: 768px) {
            .grafico {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <div id="container1" class="grafico"></div>
        <div id="container2" class="grafico"></div>
    </div>

    <script>
        var ventas = @json($ventas);

        function crearGrafico(containerId, titulo) {
            Highcharts.chart(containerId, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: titulo,
                    align: 'left'
                },
                subtitle: {
                    text: 'Fuente: Sistema de Ventas',
                    align: 'left'
                },
                xAxis: {
                    categories: ventas.map(venta => venta.fecha),
                    crosshair: true,
                    accessibility: {
                        description: 'Fechas'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Cantidad de Ventas'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Ventas',
                    data: ventas.map(venta => venta.total)
                }]
            });
        }

        crearGrafico('container1', 'Cantidad de Ventas por Día (Gráfico 1)');
        crearGrafico('container2', 'Cantidad de Ventas por Día (Gráfico 2)');
    </script>
</body>

</html>
