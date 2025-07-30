<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compra {{ $compra->comprobante }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; color: #333; }
        .header p { margin: 3px 0; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th { background-color: #f8f9fa; text-align: left; padding: 5px; border: 1px solid #ddd; }
        .table td { padding: 5px; border: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-box { margin-top: 10px; float: right; width: 50%; }
        .footer { margin-top: 30px; font-size: 10px; text-align: center; color: #666; }
        .signature { margin-top: 50px; border-top: 1px dashed #333; width: 200px; }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h2>{{ $sucursal->nombre }}</h2>
        <p>{{ $sucursal->direccion }}</p>
        <p>Teléfono: {{ $sucursal->telefono }}</p>
        <p><strong>COMPROBANTE DE COMPRA</strong></p>
        <p>N°: {{ $compra->comprobante }} | Fecha: {{ date('d/m/Y', strtotime($compra->fecha)) }}</p>
    </div>

    <!-- Datos del Laboratorio/Proveedor -->
    <table class="table">
        <tr>
            <th colspan="2">Información del Laboratorio/Proveedor</th>
        </tr>
        <tr>
            <td width="25%"><strong>Nombre:</strong></td>
            <td>{{ $compra->laboratorio->nombre ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>NIT/CI:</strong></td>
            <td>{{ $compra->laboratorio->nit ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Detalle de Productos -->
    <table class="table">
        <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="50%">Producto</th>
                <th width="15%" class="text-center">Cantidad</th>
                <th width="15%" class="text-right">P. Unitario</th>
                <th width="15%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compra->detalles as $detalle)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                <td class="text-center">{{ $detalle->cantidad }}</td>
               
                <td style="text-align: center; vertical-align: middle">Bs{{number_format($detalle->producto->precio_compra, 2)}}</td>
                <td style="text-align: center; vertical-align: middle">Bs{{number_format($costo = 
                     $detalle->cantidad * $detalle->producto->precio_compra, 2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales -->
    <div class="total-box">
        <table class="table">
            <tr>
                <th>Subtotal:</th>
                <td class="text-right">{{ number_format($compra->precio_total, 2) }}</td>
            </tr>
            @if($compra->impuesto_monto > 0)
            <tr>
                <th>Impuestos ({{ $compra->impuesto }}%):</th>
                <td class="text-right">{{ number_format($compra->impuesto_monto, 2) }}</td>
            </tr>
            @endif
            <tr>
                <th><strong>TOTAL:</strong></th>
                <td class="text-right"><strong>{{ number_format($compra->precio_total, 2) }}</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="border: none; padding-top: 10px;">
                    <small><strong>Total:</strong> {{ $literal }}</small>
                </td>
            </tr>
        </table>
    </div>

    <!-- Firmas y footer -->
    <div style="clear: both;"></div>
    <div class="signature">
        <p class="text-center">Firma del Responsable</p>
    </div>
    
    <div class="footer">
        Generado el: {{ $fecha_generacion }} | {{ config('app.name') }}
    </div>
</body>
</html>