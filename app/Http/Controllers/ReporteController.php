<?php

namespace App\Http\Controllers;
use App\Models\MovimientoCaja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DatePeriod; // Importación añadida
use DateInterval; // Importación añadida
use DateTime; // Importación añadida
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
        // Validación de fechas
        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);
    
        $fecha_inicio = $validated['fecha_inicio'];
        $fecha_fin = $validated['fecha_fin'];
    
        // Optimización: Consulta directa con agregación en base de datos
        $dias_rango = Carbon::parse($fecha_inicio)->diffInDays($fecha_fin);
    
        if ($dias_rango <= 30) {
            // Agrupación por día
            $resultados = MovimientoCaja::whereBetween('created_at', [$fecha_inicio, $fecha_fin])
                ->where('tipo', 'INGRESO')
                ->selectRaw('DATE(created_at) as fecha, SUM(monto) as total')
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->get();
    
            // Rellenar días sin movimientos
            $periodo = new DatePeriod(
                new DateTime($fecha_inicio),
                new DateInterval('P1D'),
                (new DateTime($fecha_fin))->modify('+1 day')
            );
    
            $datos = [];
            $labels = [];
            $resultadosPorFecha = $resultados->pluck('total', 'fecha');
    
            foreach ($periodo as $fecha) {
                $fecha_formato = $fecha->format('Y-m-d');
                $labels[] = $fecha_formato;
                $datos[] = $resultadosPorFecha->get($fecha_formato, 0);
            }
        } else {
            // Agrupación por mes
            $resultados = MovimientoCaja::whereBetween('created_at', [$fecha_inicio, $fecha_fin])
                ->where('tipo', 'INGRESO')
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, SUM(monto) as total')
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();
    
            // Rellenar meses sin movimientos
            $fechaIni = Carbon::parse($fecha_inicio)->startOfMonth();
            $fechaFin = Carbon::parse($fecha_fin)->endOfMonth();
            
            $datos = [];
            $labels = [];
            $resultadosPorMes = $resultados->pluck('total', 'mes');
    
            while ($fechaIni <= $fechaFin) {
                $mes = $fechaIni->format('Y-m');
                $labels[] = $mes;
                $datos[] = $resultadosPorMes->get($mes, 0);
                $fechaIni->addMonth();
            }
        }
    
        $total = array_sum($datos);
    
        return view('admin.reporte.ingresos', compact('labels', 'datos', 'total'));
    }
    

    public function ingresosPorFechaPDF(Request $request)
    {
        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);
    
        $fechaInicio = Carbon::parse($validated['fecha_inicio'])->startOfDay();
        $fechaFin = Carbon::parse($validated['fecha_fin'])->endOfDay();
    
        // FILTRAR SOLO INGRESOS
        $ingresos = MovimientoCaja::whereBetween('created_at', [$fechaInicio, $fechaFin])
                    ->where('tipo', 'INGRESO') // Este filtro es crucial
                    ->orderBy('created_at')
                    ->get();
    
        $total = $ingresos->sum('monto');
    
        $pdf = Pdf::loadView('admin.reporte.ingresos_por_fecha_pdf', [
            'ingresos' => $ingresos,
            'total' => $total,
            'fechaInicio' => $fechaInicio->format('d/m/Y'),
            'fechaFin' => $fechaFin->format('d/m/Y')
        ]);
    
        return $pdf->stream('reporte_ingresos.pdf');
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


public function EgresosPorFechaPDF(Request $request)
{
    $validated = $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
    ]);

    $fechaInicio = Carbon::parse($validated['fecha_inicio'])->startOfDay();
    $fechaFin = Carbon::parse($validated['fecha_fin'])->endOfDay();

    // FILTRAR SOLO INGRESOS
    $egresos = MovimientoCaja::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->where('tipo', 'EGRESO') // Este filtro es crucial
                ->orderBy('created_at')
                ->get();

    $total = $egresos->sum('monto');

    $pdf = Pdf::loadView('admin.reporte.egresos_por_fecha_pdf', [
        'egresos' => $egresos,
        'total' => $total,
        'fechaInicio' => $fechaInicio->format('d/m/Y'),
        'fechaFin' => $fechaFin->format('d/m/Y')
    ]);

    return $pdf->stream('reporte_egresos.pdf');
}





}
