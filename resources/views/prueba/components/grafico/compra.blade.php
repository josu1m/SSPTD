<div id="container1" class="container"></div>

@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        Highcharts.chart('container1', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Compras diarias'
            },
            subtitle: {
                align: 'left',
                text: 'Haz clic en las columnas para ver detalles por proveedor'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Número de compras'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> compras<br/>'
            },
            series: [{
                name: 'Compras diarias',
                colorByPoint: true,
                data: [
                    @foreach ($datosGrafico1 as $fecha => $datos)
                        {
                            name: '{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}',
                            y: {{ $datos['count'] }},
                            drilldown: '{{ $fecha }}'
                        },
                    @endforeach
                ]
            }],
            drilldown: {
                series: [
                    @foreach ($datosGrafico1 as $fecha => $datos)
                        {
                            name: '{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}',
                            id: '{{ $fecha }}',
                            data: [
                                @foreach ($datos['proveedores'] as $proveedor => $cantidad)
                                    ['{{ $proveedor }}', {{ $cantidad }}],
                                @endforeach
                            ]
                        },
                    @endforeach
                ]
            }
        });
    </script>
@endpush
