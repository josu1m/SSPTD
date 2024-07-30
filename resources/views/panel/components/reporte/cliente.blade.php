<div id="container_clientes" style="width: 100%; height: 400px;"></div>

@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Highcharts.chart('container_clientes', {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: 'Clientes por semana'
                },
                subtitle: {
                    align: 'left',
                    text: 'Haz clic en las columnas para ver detalles por tipo de documento'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Número de clientes'
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
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> clientes<br/>'
                },
                series: [{
                    name: 'Clientes por semana',
                    colorByPoint: true,
                    data: {!! json_encode(
                        $datosClientes->map(function ($dato) {
                            return [
                                'name' => $dato['week'],
                                'y' => $dato['y'],
                                'drilldown' => $dato['week'],
                            ];
                        }),
                    ) !!}
                }],
                drilldown: {
                    series: {!! json_encode(
                        $datosClientes->map(function ($dato) {
                            return [
                                'name' => $dato['week'],
                                'id' => $dato['week'],
                                'data' => $dato['drilldown'],
                            ];
                        }),
                    ) !!}
                }
            });
        });
    </script>
@endpush
