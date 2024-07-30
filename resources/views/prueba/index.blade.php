@extends('layouts.app')

@section('title', 'Panel')


@section('content')
    <h2>PRUEBA</h2>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 48rem;">
            <div class="card-body">
                @include('prueba.components.grafico.venta')

            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 48rem;">
            <div class="card-body">
                @include('prueba.components.grafico.compra')

            </div>
        </div>
    </div>
@endsection

<style>
    .mn {
        background-color: rgb(96, 96, 134);
        width: 100%;
        height: 100%;
    }
</style>
