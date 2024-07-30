<div id="container_producto_no" style="width: 100%; height: 400px;"></div>
@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener los datos del controlador
            var datosVendidoProducto = @json($datosVendidoProducto);

            Highcharts.chart('container_producto_no', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Cantidad de abarrotes disponible',
                    align: 'left'
                },
                subtitle: {
                    text: 'Datos de stock por producto',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.0f}</b> <p>unidades</p>' // Mostrar cantidad en tooltip
                },
                accessibility: {
                    point: {
                        valueSuffix: ''
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b><br>{point.y:.0f}', // Mostrar cantidad en dataLabels
                            distance: 20
                        }
                    }
                },
                series: [{
                    name: 'Stock',
                    colorByPoint: true,
                    data: datosVendidoProducto
                }]
            });
        });
    </script>
@endpush
