@extends('layouts.app') {{-- Usualmente layouts.app es el layout principal en Argon --}}

@section('title', 'Egresos por Fecha')

@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <h1 class="text-white">Buscar Egresos por Fecha</h1>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.reporte.egresos_por_fecha') }}" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha Inicio:</label>
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="fecha_fin">Fecha Fin:</label>
                            <input type="date" name="fecha_fin" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                </div>

                @if(request('fecha_inicio') && request('fecha_fin'))
                    <div class="mt-3">
                        <a href="{{ route('admin.reporte.egresos_por_fecha_pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}" 
                           class="btn btn-danger" target="_blank">
                            Generar PDF
                        </a>
                    </div>
                @endif
            </form>

            <hr>

            @if (isset($labels) && isset($datos))
                <h3>Resultados:</h3>
                <canvas id="graficoEgresos" height="100"></canvas>
                <h4 class="mt-3">Total Egresos: <span class="text-dark">Bs {{ number_format($total, 2) }}</span></h4>

            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let graficoEgresos;

    function crearGrafico(labels, datos) {
        const ctx = document.getElementById('graficoEgresos').getContext('2d');

        if (graficoEgresos) {
            graficoEgresos.destroy();
        }

        const palette = [
            'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)', 
            'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)', 
            'rgba(199, 199, 199, 0.7)', 'rgba(83, 102, 255, 0.7)', 'rgba(255, 99, 71, 0.7)', 
            'rgba(60, 179, 113, 0.7)'
        ];

        const backgroundColors = datos.map((_, index) => palette[index % palette.length]);
        const borderColors = datos.map((_, index) => palette[index % palette.length].replace('0.7', '1'));

        graficoEgresos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Egresos (Bs)',
                    data: datos,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    @if(isset($labels) && isset($datos))
        crearGrafico(@json($labels), @json($datos));
    @endif
</script>
@endpush

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let graficoEgresos;

    function crearGrafico(labels, datos) {
        const ctx = document.getElementById('graficoEgresos').getContext('2d');

        if (graficoEgresos) {
            graficoEgresos.destroy();
        }

        const palette = [
            'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)', 
            'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)', 
            'rgba(199, 199, 199, 0.7)', 'rgba(83, 102, 255, 0.7)', 'rgba(255, 99, 71, 0.7)', 
            'rgba(60, 179, 113, 0.7)'
        ];

        const backgroundColors = datos.map((_, index) => palette[index % palette.length]);
        const borderColors = datos.map((_, index) => palette[index % palette.length].replace('0.7', '1'));

        graficoEgresos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Egresos (Bs)',
                    data: datos,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    @if(isset($labels) && isset($datos))
        crearGrafico(@json($labels), @json($datos));
    @endif
</script>
@endsection
