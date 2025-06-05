<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cajas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .date-range { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Reporte de Cajas</div>
        @if($fechaInicio || $fechaFin)
            <div class="date-range">
                Período: {{ $fechaInicio }} al {{ $fechaFin }}
            </div>
        @endif
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha Apertura</th>
                <th>Fecha Cierre</th>
                <th>Monto Inicial</th>
                <th>Total Ingresos</th>
                <th>Total Egresos</th>
                <th>Saldo</th>
                <th>Sucursal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cajas as $caja)
            <tr>
                <td>{{ $caja->id }}</td>
                <td>{{ $caja->fecha_apertura }}</td>
                <td>{{ $caja->fecha_cierre ?? 'Abierta' }}</td>
                <td>{{ number_format($caja->monto_inicial, 2) }}</td>
                <td>{{ number_format($caja->total_ingresos, 2) }}</td>
                <td>{{ number_format($caja->total_egresos, 2) }}</td>
                <td>{{ number_format($caja->saldo, 2) }}</td>
                <td>{{ $caja->sucursal->nombre ?? 'N/A' }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4">TOTALES</td>
                <td>{{ number_format($totalGeneralIngresos, 2) }}</td>
                <td>{{ number_format($totalGeneralEgresos, 2) }}</td>
                <td>{{ number_format($saldoGeneral, 2) }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>