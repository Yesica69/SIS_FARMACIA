<?php

namespace App\Http\Controllers;


use App\Models\Caja;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\Sucursal;
use App\Models\MovimientoCaja;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

// Para download()
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB; // ¡Este es el import que faltaba!
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use DatePeriod; // Importación añadida
use DateInterval; // Importación añadida
use DateTime; // Importación añadida

use Symfony\Component\HttpFoundation\BinaryFileResponse;
class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cajaAbierto = Caja::whereNull('fecha_cierre')->first();
        $cajas = Caja::with('movimientos')->get();

        foreach ($cajas as $caja){
            $caja->total_ingresos = $caja->movimientos->where('tipo','INGRESO')->sum('monto');
            $caja->total_egresos = $caja->movimientos->where('tipo','EGRESO')->sum('monto');
        }
        return view ('admin.cajas.index',compact('cajas','cajaAbierto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view ('admin.cajas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //$datos = request()->all();
        //return response()->json($datos);

        $request->validate([
            'fecha_apertura' => 'required|date',
        ]);
        
        $caja = new Caja();
        $caja->fecha_apertura = $request->fecha_apertura;
        $caja->monto_inicial = $request->monto_inicial;
        $caja->descripcion = $request->descripcion;
        $caja->sucursal_id = Auth::user()->sucursal_id; // asignar sucursal_id
        
        $caja->save(); // guardar la nueva caja en la base de datos
        
        return redirect()->route('admin.cajas.index')->with('success', 'Caja registrada exitosamente.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    // Obtener la caja por el id
    $caja = Caja::find($id); // 'find' ya devuelve un único modelo, no necesitas usar 'first()'

    // Obtener los movimientos asociados a esa caja
    $movimientos = MovimientoCaja::where('caja_id', $id)->get();

    // Retornar la vista con los datos de la caja y los movimientos
    return view('admin.cajas.show', compact('caja', 'movimientos')); // Se pasa 'movimientos'
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caja $caja, $id)
    {
        //
        $caja = Caja::finf($id)->first ();
        return view ('admin.cajas.edit',compact('caja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_apertura' => 'required|date',
        ]);
        
        $caja = Caja::find($id);
        $caja->fecha_apertura = $request->fecha_apertura;
        $caja->monto_inicial = $request->monto_inicial;
        $caja->descripcion = $request->descripcion;
        $caja->sucursal_id = Auth::user()->sucursal_id; // asignar sucursal_id
        
        $caja->save(); // guardar la nueva caja en la base de datos
        
        return redirect()->route('admin.cajas.index')->with('success', 'Caja actualizada exitosamente.');
        
    }

    /**
     * Remove the specified resource from storage.
     */

     public function ingresoegreso($id)
     {
         //
        $caja = Caja::find($id);
         return view('admin.cajas.ingresos_egreso',compact('caja'));
     }

     public function store_ingresos_egresos(Request $request)
     {
         // Validación adicional para asegurarse de que el ID no sea nulo y exista
         $request->validate([
             'monto' => 'required',
             'id' => 'required|exists:cajas,id', // Validamos que el id exista en la tabla `cajas`
         ]);
     
         $movimiento = new MovimientoCaja();
     
         $movimiento->tipo = $request->tipo;
         $movimiento->monto = $request->monto;
         $movimiento->descripcion = $request->descripcion;
         $movimiento->caja_id = $request->id; // Ahora podemos estar más seguros de que no será null
     
         $movimiento->save(); // Guardamos el movimiento en la base de datos
         return redirect()->route('admin.cajas.index')
         ->with('mensaje', 'Se elimino la compra correctamente')
         ->with('icono','success');
     }
     
     public function cierre ($id)
     {
         //
         $caja = Caja::find($id);
         return view('admin.cajas.cierre',compact('caja'));
     }

     public function store_cierre (Request $request)
     {
         //
         $caja = Caja::find($request->id);
         $caja->fecha_cierre = $request->fecha_cierre;
         $caja->monto_final = $request->monto_final;
         $caja->save();

         return redirect()->route('admin.cajas.index')
         ->with('mensaje', 'Se registro el cierre correctamente')
         ->with('icono','success');
        
     }


    public function destroy( $id)
    {
        //
        Caja::destroy($id); // Buscar el usuario por ID
      

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.cajas.index')
            ->with('mensaje', 'Caja eliminado con éxito.')
            ->with('icono', 'success');
    
    }


     // Nombres constantes para archivos
    const NOMBRE_ARCHIVO_PDF = 'reporte-cajas.pdf';
    const NOMBRE_ARCHIVO_EXCEL = 'reporte-cajas.xlsx';
    const NOMBRE_ARCHIVO_CSV = 'reporte-cajas.csv';
    
    // Tipos de reporte permitidos
    const TIPOS_REPORTE = ['pdf', 'excel', 'csv'];

    /**
     * Genera reportes de caja en diferentes formatos
     */
    public function reportecaja($tipo, Request $request)
    {
        // Validar tipo de reporte
        if (!in_array($tipo, self::TIPOS_REPORTE)) {
            abort(400, 'Tipo de reporte no válido. Los tipos permitidos son: ' . implode(', ', self::TIPOS_REPORTE));
        }

        // Obtener parámetros de filtrado
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $clienteId = $request->input('cliente_id');
        
        // Consulta base con eager loading
        $query = Caja::with(['movimientos', 'sucursal'])
            ->orderBy('fecha_apertura', 'desc');
        
        // Aplicar filtros
        if ($fechaInicio) {
            $query->where('fecha_apertura', '>=', $fechaInicio);
        }
        
        if ($fechaFin) {
            $query->where('fecha_apertura', '<=', $fechaFin);
        }
        
        if ($clienteId) {
            $query->whereHas('movimientos', function($q) use ($clienteId) {
                $q->where('cliente_id', $clienteId);
            });
        }
        
        $cajas = $query->get();
        
        // Preparar datos para el reporte
        $data = $this->prepareReportData($cajas, $fechaInicio, $fechaFin);

        // Generar el reporte según el tipo solicitado
        switch ($tipo) {
            case 'pdf':
                return $this->generatePdf($data);
                
            case 'excel':
                return $this->generateExcel($data);
                
            case 'csv':
                return $this->generateCsv($data);
        }
    }

    /**
     * Prepara los datos para los reportes
     */
    protected function prepareReportData($cajas, $fechaInicio, $fechaFin): array
    {
        $totalGeneralIngresos = 0;
        $totalGeneralEgresos = 0;
        
        foreach ($cajas as $caja) {
            $caja->total_ingresos = $caja->movimientos->where('tipo', 'INGRESO')->sum('monto');
            $caja->total_egresos = $caja->movimientos->where('tipo', 'EGRESO')->sum('monto');
            $caja->saldo = ($caja->monto_inicial + $caja->total_ingresos) - $caja->total_egresos;
            $caja->nombre_sucursal = optional($caja->sucursal)->nombre ?? 'N/A';
            
            $totalGeneralIngresos += $caja->total_ingresos;
            $totalGeneralEgresos += $caja->total_egresos;
        }
        
        return [
            'cajas' => $cajas,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'totalGeneralIngresos' => $totalGeneralIngresos,
            'totalGeneralEgresos' => $totalGeneralEgresos,
            'saldoGeneral' => ($totalGeneralIngresos - $totalGeneralEgresos)
        ];
    }

    /**
     * Genera el reporte en PDF
     */
    protected function generatePdf(array $data): BinaryFileResponse
{
    $pdf = Pdf::loadView('admin.cajas.reporte', $data);
    $output = $pdf->output();
    
    $tempPath = tempnam(sys_get_temp_dir(), 'pdf_');
    file_put_contents($tempPath, $output);
    
    return new BinaryFileResponse($tempPath, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="'.self::NOMBRE_ARCHIVO_PDF.'"'
    ]);
}


    /**
     * Genera el reporte en Excel
     */
    protected function generateExcel(array $data): BinaryFileResponse
    {
        $exportData = $this->prepareExportData($data);
        
        return Excel::download(
            new class($exportData) implements FromArray, WithHeadings {
                public function __construct(private array $data) {}
                
                public function array(): array {
                    return $this->data['rows'];
                }
                
                public function headings(): array {
                    return $this->data['headers'];
                }
            },
            self::NOMBRE_ARCHIVO_EXCEL
        );
    }

    /**
     * Genera el reporte en CSV
     */
    protected function generateCsv(array $data): BinaryFileResponse
    {
        $exportData = $this->prepareExportData($data);
        
        return Excel::download(
            new class($exportData) implements FromArray, WithHeadings {
                public function __construct(private array $data) {}
                
                public function array(): array {
                    return $this->data['rows'];
                }
                
                public function headings(): array {
                    return $this->data['headers'];
                }
            },
            self::NOMBRE_ARCHIVO_CSV,
            \Maatwebsite\Excel\Excel::CSV,
            ['Content-Type' => 'text/csv']
        );
    }

    /**
     * Prepara los datos para exportación (Excel/CSV)
     */
    protected function prepareExportData(array $data): array
    {
        $headers = [
            'ID', 'Fecha Apertura', 'Fecha Cierre', 
            'Monto Inicial', 'Total Ingresos', 
            'Total Egresos', 'Saldo', 
            'Sucursal', 'Descripción'
        ];

        $rows = [];
        
        foreach ($data['cajas'] as $caja) {
            $rows[] = [
                $caja->id,
                $caja->fecha_apertura->format('Y-m-d H:i:s'),
                $caja->fecha_cierre ? $caja->fecha_cierre->format('Y-m-d H:i:s') : 'Abierta',
                number_format($caja->monto_inicial, 2),
                number_format($caja->total_ingresos, 2),
                number_format($caja->total_egresos, 2),
                number_format($caja->saldo, 2),
                $caja->nombre_sucursal,
                $caja->descripcion
            ];
        }

        // Agregar totales
        $rows[] = [];
        $rows[] = [
            '', '', '', '',
            number_format($data['totalGeneralIngresos'], 2),
            number_format($data['totalGeneralEgresos'], 2),
            number_format($data['saldoGeneral'], 2),
            'TOTALES', ''
        ];

        return [
            'headers' => $headers,
            'rows' => $rows
        ];
    }

 

}
