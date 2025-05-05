@extends('adminlte::page')

@section('title', 'Ingresos por Fecha')

@section('content_header')
    <h1>Buscar Ingresos por Fecha</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.reporte.ingresos_por_fecha') }}" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <label>Fecha Inicio:</label>
                        <input type="date" name="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-5">
                        <label>Fecha Fin:</label>
                        <input type="date" name="fecha_fin" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                    </div>
                </div>
                @if(request('fecha_inicio') && request('fecha_fin'))
    <div class="mt-3">
        <a href="{{ route('admin.reporte.ingresos_por_fecha_pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}" 
           class="btn btn-danger" target="_blank">
            Generar PDF
        </a>
    </div>
@endif
            </form>

            <hr>

            @if (isset($labels) && isset($datos))
                <h3>Resultados:</h3>
                <canvas id="graficoIngresos" height="100"></canvas>

                <h4 class="mt-3">Total Ingresos: Bs {{ number_format($total, 2) }}</h4>
            @endif
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let graficoIngresos;

        function crearGrafico(labels, datos) {
    const ctx = document.getElementById('graficoIngresos').getContext('2d');

    if (graficoIngresos) {
        graficoIngresos.destroy();
    }

    const palette = [
        'rgba(255, 99, 132, 0.7)', 
        'rgba(54, 162, 235, 0.7)', 
        'rgba(255, 206, 86, 0.7)', 
        'rgba(75, 192, 192, 0.7)', 
        'rgba(153, 102, 255, 0.7)', 
        'rgba(255, 159, 64, 0.7)', 
        'rgba(199, 199, 199, 0.7)', 
        'rgba(83, 102, 255, 0.7)', 
        'rgba(255, 99, 71, 0.7)', 
        'rgba(60, 179, 113, 0.7)'
    ];

    const backgroundColors = datos.map((valor, index) => palette[index % palette.length]);
    const borderColors = datos.map((valor, index) => palette[index % palette.length].replace('0.7', '1'));

    graficoIngresos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ingresos (Bs)',
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
@stop
