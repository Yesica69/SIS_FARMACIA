<?php

namespace App\Http\Controllers;
use App\Models\MovimientoCaja;
use Carbon\Carbon;
use Illuminate\Http\Request;
// Asegúrate de tener este modelo para acceder a los datos de ingresos
use PDF; // Si estás usando domPDF o cualquier paquete para generar PDF

class ReporteController extends Controller
{
    // Método para mostrar la vista con el formulario de fechas
    public function reporteIngresosView()
    {
        return view('admin.reporte.ingresos'); // Esto buscará la vista en resources/views/reporte/ingresos.blade.php
    }

    public function ingresosPorFecha(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        $ingresos = MovimientoCaja::whereBetween('created_at', [$fecha_inicio, $fecha_fin])
                               ->where('tipo', 'INGRESO')
                               ->get();

        $dias_rango = Carbon::parse($fecha_inicio)->diffInDays($fecha_fin);

        $datos = [];
        $labels = [];

        if ($dias_rango <= 30) {
            // Agrupar por día
            $periodo = new \DatePeriod(
                new \DateTime($fecha_inicio),
                new \DateInterval('P1D'),
                (new \DateTime($fecha_fin))->modify('+1 day')
            );

            foreach ($periodo as $fecha) {
                $fecha_formato = $fecha->format('Y-m-d');
                $monto = $ingresos->where('created_at', '>=', $fecha_formato . ' 00:00:00')
                                  ->where('created_at', '<=', $fecha_formato . ' 23:59:59')
                                  ->sum('monto');

                $labels[] = $fecha_formato;
                $datos[] = $monto;
            }

        } else {
            // Agrupar por mes
            $fechaIni = Carbon::parse($fecha_inicio)->startOfMonth();
            $fechaFin = Carbon::parse($fecha_fin)->endOfMonth();
            while ($fechaIni <= $fechaFin) {
                $mes = $fechaIni->format('Y-m');

                $monto = $ingresos->filter(function ($ingreso) use ($mes) {
                    return $ingreso->created_at->format('Y-m') === $mes;
                })->sum('monto');

                $labels[] = $mes;
                $datos[] = $monto;

                $fechaIni->addMonth();
            }
        }

        $total = array_sum($datos);

        return view('admin.reporte.ingresos', compact('labels', 'datos', 'total'));
    }
    

    public function ingresosPorFechaPDF(Request $request)
{
    $fechaInicio = $request->fecha_inicio;
    $fechaFin = $request->fecha_fin;

    $ingresos =MovimientoCaja::whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
                        ->orderBy('created_at', 'asc')
                        ->get();

    $total = $ingresos->sum('monto');

    $pdf = Pdf::loadView('admin.reporte.ingresos_por_fecha_pdf', compact('ingresos', 'total', 'fechaInicio', 'fechaFin'));
    
    return $pdf->stream('ingresos_por_fecha.pdf');
}



//EGRESOS 

public function reporteEgresosView()
{
    return view('admin.reporte.egresos'); // Esto buscará la vista en resources/views/reporte/ingresos.blade.php
}

public function egresosPorFecha(Request $request)
{
    $fecha_inicio = $request->input('fecha_inicio');
    $fecha_fin = $request->input('fecha_fin');

    $egresos = MovimientoCaja::whereBetween('created_at', [$fecha_inicio, $fecha_fin])
                           ->where('tipo', 'EGRESO')
                           ->get();

    $dias_rango = Carbon::parse($fecha_inicio)->diffInDays($fecha_fin);

    $datos = [];
    $labels = [];

    if ($dias_rango <= 30) {
        // Agrupar por día
        $periodo = new \DatePeriod(
            new \DateTime($fecha_inicio),
            new \DateInterval('P1D'),
            (new \DateTime($fecha_fin))->modify('+1 day')
        );

        foreach ($periodo as $fecha) {
            $fecha_formato = $fecha->format('Y-m-d');
            $monto = $egresos->where('created_at', '>=', $fecha_formato . ' 00:00:00')
                              ->where('created_at', '<=', $fecha_formato . ' 23:59:59')
                              ->sum('monto');

            $labels[] = $fecha_formato;
            $datos[] = $monto;
        }

    } else {
        // Agrupar por mes
        $fechaIni = Carbon::parse($fecha_inicio)->startOfMonth();
        $fechaFin = Carbon::parse($fecha_fin)->endOfMonth();
        while ($fechaIni <= $fechaFin) {
            $mes = $fechaIni->format('Y-m');

            $monto = $egresos->filter(function ($egreso) use ($mes) {
                return $egreso->created_at->format('Y-m') === $mes;
            })->sum('monto');

            $labels[] = $mes;
            $datos[] = $monto;

            $fechaIni->addMonth();
        }
    }

    $total = array_sum($datos);

    return view('admin.reporte.egresos', compact('labels', 'datos', 'total'));
}


public function egresosPorFechaPDF(Request $request)
{
$fechaInicio = $request->fecha_inicio;
$fechaFin = $request->fecha_fin;

$egresos =MovimientoCaja::whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
                    ->orderBy('created_at', 'asc')
                    ->get();

$total = $ingresos->sum('monto');

$pdf = Pdf::loadView('admin.reporte.egresos_por_fecha_pdf', compact('egresos', 'total', 'fechaInicio', 'fechaFin'));

return $pdf->stream('egresos_por_fecha.pdf');
}






}
