@extends('layouts.app')

@section('title', 'Panel')


@section('content')

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                let message = "{{ session('success') }}";
                Swal.fire(message);

            });
        </script>
    @endif

    <div class="container-fluid px-4">
        <h1 class="mt-4">Prueba</h1>
        <div class="p-6 text-gray-900">
            <x-grafico :title="$chartConfig['title']" :yAxisLabel="$chartConfig['yAxisLabel']" :xAxisLabel="$chartConfig['xAxisLabel']" :data="$chartConfig['data']"
                :colors="$chartConfig['colors']" :width="$chartConfig['width']" :height="$chartConfig['height']" />
        </div>

    </div>
@endsection

<style>
    .mn{
        background-color: rgb(96, 96, 134);
        width: 100%;
        height: 100%;
    }
</style>
