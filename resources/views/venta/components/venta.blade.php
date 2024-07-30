<div class="table-container custom-table-container">
    <h2>CANTIDAD DE VENTAS POR </h2>

    <table class="custom-table">
        <thead>
            <tr class="custom-header-row">
                <th class="custom-header">Fecha</th>
                <th class="custom-header">Total Ventas </th>
                <th class="custom-header">Vendedor </th>
                <th class="custom-header">Total Ventas por Vendedor
                </th>


            </tr>
        </thead>
        <tbody class="custom-tbody">
            @foreach ($datosTabla as $data)
                @foreach ($data['vendedores'] as $vendedor)
                    <tr class="custom-row">
                        @if ($loop->first)
                            <td rowspan="{{ count($data['vendedores']) }}" class="custom-cell comprobante-cell">
                                {{ $data['fecha'] }}</td>
                            <td rowspan="{{ count($data['vendedores']) }}" class="custom-cell comprobante-cell">
                                {{ $data['total_ventas'] }}</td>
                        @endif
                        <td class="custom-cell total-cell">
                            {{ $vendedor['nombre_vendedor'] }} </td>
                        <td class="custom-cell cliente-cell">
                            {{ $vendedor['total_ventas'] }} </td>
                    </tr>
                @endforeach
            @endforeach

        </tbody>
        <tfoot>
            <tr class="total-row custom-total-row">
                <td colspan="3" class="right-align custom-total-label">VENTA TOTAL</td>
                <td class="right-align custom-total-amount">
                    {{ $totalVentas }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<style>
    .custom-table-container {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .custom-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.1);
    }

    .custom-header,
    .custom-cell {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
    }

    .custom-header {
        background-color: #3498db;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-row:nth-child(even) {
        background-color: #f8f8f8;
    }

    .right-align {
        text-align: right;
    }

    .custom-total-row {
        font-weight: bold;
        background-color: #ecf0f1;
    }

    .custom-total-row td {
        border-top: 2px solid #3498db;
    }

    .cantidad {
        text-align: center;
    }

    .producto {
        font-weight: 500;
    }

    /* Nuevas clases personalizadas */
    .comprobante-cell {
        font-style: italic;
    }

    .cliente-cell {
        font-weight: bold;
    }

    .vendedor-cell {
        color: #3498db;
    }

    .total-cell {
        font-weight: bold;
        color: #2ecc71;
    }

    .custom-total-label {
        font-size: 1.2em;
        color: #34495e;
    }

    .custom-total-amount {
        background-color: #2ecc71;
    }

    .custom-total-text {
        margin: 0;
        padding: 5px;
    }
</style>
