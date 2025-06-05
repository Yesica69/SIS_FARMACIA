<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Compras</title>
    <style>
        @page { margin: 1cm; size: A4 landscape; }
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h1 { color: #2c3e50; font-size: 14pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #3498db; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .footer { margin-top: 20px; font-size: 9pt; text-align: right; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Compras</h1>
        <p>Generado el: {{ $fecha_generacion }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Comprobante</th>
                <th>Laboratorio</th>
                <th class="text-right">Total</th>
                <th>Productos</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
            <tr>
                <td>{{ $compra->fecha }}</td>
                <td>{{ $compra->comprobante }}</td>
                <td>{{ $compra->laboratorio->nombre }}</td>
                <td class="text-right">{{ number_format($compra->precio_total, 2) }}</td>
                <td>{{ $compra->detalles->count() }}</td>
                <td>{{ $compra->detalles->sum('cantidad') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total General</th>
                <th class="text-right">{{ number_format($compras->sum('precio_total'), 2) }}</th>
                <th>{{ $compras->sum(function($c) { return $c->detalles->count(); }) }}</th>
                <th>{{ $compras->sum(function($c) { return $c->detalles->sum('cantidad'); }) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generado por: {{ Auth::user()->name }} - {{ $fecha_generacion }}
    </div>
</body>
</html>