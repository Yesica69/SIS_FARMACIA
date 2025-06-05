<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Productos </title>
    <style>
        @page {
            margin: 1cm;
            size: A4 landscape;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 9pt;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #2c3e50;
            font-size: 14pt;
            margin: 5px 0;
        }
        .header p {
            color: #7f8c8d;
            font-size: 9pt;
            margin: 3px 0;
        }
        .company-info {
            margin-bottom: 10px;
            text-align: center;
            font-size: 8pt;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 8pt;
            table-layout: fixed;
        }
        thead tr {
            background-color: #3498db;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }
        th, td {
            padding: 6px 8px;
            border: 1px solid #e0e0e0;
            word-wrap: break-word;
        }
        tbody tr {
            border-bottom: 1px solid #e0e0e0;
        }
        tbody tr:nth-of-type(even) {
            background-color: #f9f9f9;
        }
        tbody tr:last-of-type {
            border-bottom: 2px solid #3498db;
        }
        tbody tr:hover {
            background-color: #f1f9ff;
        }
        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 8pt;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .highlight {
            background-color: #fffde7;
        }
        .logo {
            max-width: 100px;
            max-height: 40px;
            margin-bottom: 5px;
        }
        .signature {
            margin-top: 20px;
            border-top: 1px dashed #ccc;
            width: 200px;
            padding-top: 5px;
            text-align: center;
            font-size: 8pt;
        }
        /* Anchuras específicas para columnas */
        .col-code { width: 7%; }
        .col-name { width: 12%; }
        .col-desc { width: 15%; }
        .col-cat { width: 10%; }
        .col-lab { width: 10%; }
        .col-stock { width: 5%; }
        .col-min { width: 5%; }
        .col-max { width: 5%; }
        .col-price-buy { width: 7%; }
        .col-price-sell { width: 7%; }
        .col-date-in { width: 7%; }
        .col-date-out { width: 7%; }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://ejemplo.com/logo.png" alt="Logo Empresa" class="logo">
        <h1>REPORTE DE INVENTARIO DE PRODUCTOS</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="company-info">
        <strong>{{ config('app.name') }}</strong> | 
        Dirección: Calle P, Ciudad | 
        Teléfono:  | Email: info
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-code">Código</th>
                <th class="col-name">Nombre</th>
                <th class="col-desc">Descripción</th>
                <th class="col-cat">Categoría</th>
                <th class="col-lab">Laboratorio</th>
                <th class="col-stock text-right">Stock</th>
                <th class="col-min text-right">Mín</th>
                <th class="col-max text-right">Máx</th>
                <th class="col-price-buy text-right">P. Compra</th>
                <th class="col-price-sell text-right">P. Venta</th>
                <th class="col-date-in text-center">Ingreso</th>
                <th class="col-date-out text-center">Vencim.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr class="{{ $producto->stock < $producto->stock_minimo ? 'highlight' : '' }}">
                <td class="col-code">{{ $producto->codigo }}</td>
                <td class="col-name">{{ Str::limit($producto->nombre, 20) }}</td>
                <td class="col-desc">{{ Str::limit($producto->descripcion, 30) }}</td>
                <td class="col-cat">{{ Str::limit($producto->categoria->nombre, 15) }}</td>
                <td class="col-lab">{{ Str::limit($producto->laboratorio->nombre, 15) }}</td>
                <td class="col-stock text-right">{{ $producto->stock }}</td>
                <td class="col-min text-right">{{ $producto->stock_minimo }}</td>
                <td class="col-max text-right">{{ $producto->stock_maximo }}</td>
                <td class="col-price-buy text-right">{{ number_format($producto->precio_compra, 2) }}</td>
                <td class="col-price-sell text-right">{{ number_format($producto->precio_venta, 2) }}</td>
                <td class="col-date-in text-center">{{ $producto->fecha_ingreso->format('d/m/Y') }}</td>
                <td class="col-date-out text-center">{{ $producto->fecha_vencimiento ? $producto->fecha_vencimiento->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado por: {{ Auth::user()->name ?? 'Sistema' }} | Página {PAGE_NUM} de {PAGE_COUNT}</p>
    </div>

    <div class="signature">
        <p>Responsable del inventario</p>
        <p>_________________________</p>
    </div>
</body>
</html>