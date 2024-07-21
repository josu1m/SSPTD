<div class="table-container custom-table-container">
    <table class="custom-table">
        <thead>
            <tr class="custom-header-row">
                <th class="custom-header">Nombre</th>
                <th class="custom-header">Dirección</th>
                <th class="custom-header">Documento</th>
            </tr>
        </thead>
        <tbody class="custom-tbody">
            @foreach ($clientes as $item)
                <tr class="custom-row">
                    <td class="custom-cell comprobante-cell">
                        <p class="comprobante-tipo">
                            {{ $item->persona->razon_social }}
                        </p>
                    </td>
                    <td class="custom-cell cliente-cell">
                        <p class="cliente-razon-social">
                            {{ $item->persona->direccion }}
                        </p>
                    </td>
                    <td class="custom-cell vendedor-cell">{{ $item->persona->documento->tipo_documento }}:
                        {{ $item->persona->numero_documento }}</p>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row custom-total-row">
                <td colspan="2" class="right-align custom-total-label">TOTAL CLIENTES</td>
                <td class="right-align custom-total-amount" style="text-align: center;">
                    {{ $totalClientes }}

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
        background-color: #abe2c2;
        border-radius: 10px
    }

    .custom-total-text {
        margin: 0;
        padding: 5px;
    }
</style>
