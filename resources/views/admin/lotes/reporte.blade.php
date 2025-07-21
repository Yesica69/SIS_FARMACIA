<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Lotes </title>
    <style>
        @page { 
            margin: 1.5cm; 
            size: A4 portrait; /* Cambiado a vertical */
        }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10pt; 
            line-height: 1.5;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .header h1 { 
            color: #2c3e50; 
            font-size: 16pt;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            page-break-inside: avoid;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            font-size: 9pt;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
            color: #7f8c8d;
        }
        .logo {
            height: 60px;
            margin-bottom: 10px;
        }
    </style>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
      
        .vencido { background-color: #ffdddd; }
        .proximo { background-color: #fff3cd; }
        .sin-fecha { background-color: #f5f5f5; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
           <style>
    .compact-header {
        text-align: center;
        padding: 12px 0;
        margin-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .compact-logo {
        margin: 0 auto 10px; /* Centrado con margen inferior reducido */
    }

    .compact-logo img {
        height: 65px; 
        width: auto;
        max-width: 150px;
    }

    .compact-title {
        margin: 0;
        font-size: 18px; 
        font-weight: 600;
        color: #2d3748;
        line-height: 1.3;
    }

    .compact-subtitle {
        margin: 4px 0 0;
        font-size: 12px;
        color: #4a5568;
    }

    .compact-meta {
        margin-top: 6px;
        font-size: 11px;
        color: #718096;
    }
</style>

<div class="compact-header">
    <div class="compact-logo">
        <img src="{{ public_path('assets/img/logofarmacia.jpeg') }}" alt="Logo Farmacia">
    </div>
    
    <div>
        <h1 class="compact-title">REPORTE DE LABORATORIOS</h1>
        <p class="compact-subtitle">Farmacia Mariel</p>
        <div class="compact-meta">
            {{ $fecha_generacion }} | {{ Auth::user()->name ?? 'Sistema' }}
        </div>
    </div>
</div>

    <table>
        
        <thead>
            <tr>
                <th>Producto</th>
                <th>Código</th>
                <th>Lote</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">P. Compra</th>
                <th class="text-right">P. Venta</th>
                <th class="text-center">Ingreso</th>
                <th class="text-center">Vencimiento</th>
                <th class="text-center">Días Rest.</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lotes as $lote)
                <tr class="@if($lote->estado == 'VENCIDO') vencido @elseif($lote->estado == 'SIN FECHA') sin-fecha @elseif(is_numeric($lote->dias_restantes) && $lote->dias_restantes <= 30) proximo @endif">
                    <td>{{ $lote->producto->nombre ?? 'N/A' }}</td>
                    <td>{{ $lote->producto->codigo ?? 'N/A' }}</td>
                    <td>{{ $lote->numero_lote }}</td>
                    <td class="text-right">{{ $lote->cantidad }}</td>
                    <td class="text-right">{{ number_format($lote->precio_compra, 2) }}</td>
                    <td class="text-right">{{ number_format($lote->precio_venta, 2) }}</td>
                    <td class="text-center">{{ $lote->fecha_ingreso_formatted }}</td>
                    <td class="text-center">{{ $lote->fecha_vencimiento_formatted }}</td>
                    <td class="text-center">{{ is_numeric($lote->dias_restantes) ? max(0, $lote->dias_restantes) : $lote->dias_restantes }}</td>
                    <td class="text-center">{{ $lote->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
     <div class="footer">
        <p>Sistema de Gestión - {{ date('Y') }} </p>
        <p>Generado por: {{ Auth::user()->name ?? 'Sistema' }}</p>
    </div>
</body>
</html>