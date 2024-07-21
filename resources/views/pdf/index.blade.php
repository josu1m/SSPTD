@extends('layouts.app')

@section('title', 'usuarios')

@push('css-datatable')
@endpush

@push('css')
    <style>
        :root {
            padding: 0;
            margin: 0;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #3498db;
            color: white;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        tbody tr:hover {
            background-color: #e8f4f8;
            transition: background-color 0.3s ease;
        }

        td:first-child {
            font-weight: bold;
            color: #3498db;
        }

        @media (max-width: 600px) {
            table {
                font-size: 14px;
            }

            th,
            td {
                padding: 10px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="table-container">
        <a href="{{ route('pdf.generate-pdf') }}" class="btn btn-primary">Generate PDF</a>

        <table>
            <thead>
                <tr>
                    <th>Comprobante</th>
                    <th>Cliente</th>
                    <th>Fecha y hora</th>
                    <th>Vendedor</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $item)
                    <tr>
                        <td>
                            <p class="fw-semibold mb-1">{{ $item->comprobante->tipo_comprobante }}</p>
                            <p class="text-muted mb-0">{{ $item->numero_comprobante }}</p>
                        </td>
                        <td>
                            <p class="fw-semibold mb-1">{{ ucfirst($item->cliente->persona->tipo_persona) }}</p>
                            <p class="text-muted mb-0">{{ $item->cliente->persona->razon_social }}</p>
                        </td>
                        <td>
                            <div class="row-not-space">
                                <p class="fw-semibold mb-1"><span class="m-1"><i
                                            class="fa-solid fa-calendar-days"></i></span>{{ \Carbon\Carbon::parse($item->fecha_hora)->format('d-m-Y') }}
                                </p>
                                <p class="fw-semibold mb-0"><span class="m-1"><i
                                            class="fa-solid fa-clock"></i></span>{{ \Carbon\Carbon::parse($item->fecha_hora)->format('H:i') }}
                                </p>
                            </div>
                        </td>
                        <td>
                            {{ $item->user->name }}
                        </td>
                        <td>
                            {{ $item->total }}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 bg-gray-300 rounded-lg">
        <?php
        use App\Models\Venta;
        $compras = count(Venta::all());
        ?>
        <p class="text-xl font-bold text-blue-700">Total de ventas: {{ $compras }}</p>
    </div>

@endsection

@push('js')
@endpush
