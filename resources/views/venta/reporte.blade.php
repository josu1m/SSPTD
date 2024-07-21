@extends('layouts.app')

@section('title', 'ventas')
@push('css')
@endpush

@section('content')
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 48rem;">
            <div class="card-body">
                @include('venta.components.reporte.venta')


            </div>
        </div>
    </div>
@endsection
