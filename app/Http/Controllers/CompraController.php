<?php

namespace App\Http\Controllers;
use App\Models\Sucursal;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Caja;
use App\Models\MovimientoCaja;
use App\Models\TmpCompra;
use NumberToWords\NumberToWords;

use NumberFormatter;
use App\Models\Proveedor;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importar Auth
use Illuminate\Support\Facades\DB; // ¡Este es el import que faltaba!
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use DatePeriod; // Importación añadida
use DateInterval; // Importación añadida
use DateTime; // Importación añadida
// Asegúrate de tener este modelo para acceder a los datos de ingresos
use PDF; 
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cajaAbierto = Caja::whereNull('fecha_cierre')->first();
        $compras = Compra::with(['detalles','laboratorio'])->get();
        $sucursals = Sucursal::all();
        
        return view('admin.compras.index', compact('compras','cajaAbierto','sucursals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::where('sucursal_id', Auth::user()->sucursal_id)->get();
     //   $proveedores = Proveedor::where('sucursal_id', Auth::user()->sucursal_id)->get();
        $laboratorios = Laboratorio::all();
    $session_id = session()->getId();
    $tmp_compras = TmpCompra::where('session_id',$session_id)->get();

        return view('admin.compras.create', compact('productos',  'laboratorios','tmp_compras'));
    }
    
    public function store(Request $request)
    {
        // Lógica para almacenar la compra
        //$datos = request()->all();
        //return response()->json($datos);


        // Validación de los datos de entrada
        $request->validate([
            
            'fecha' => 'required',
            'comprobante' => 'required',
            'precio_total' => 'required', //
        ]);

        // Crear un nuevo laboratorio
        $compra = new Compra();
        $compra->fecha = $request->fecha;
        $compra->comprobante = $request->comprobante;
        $compra->precio_total = $request->precio_total;

        $compra->sucursal_id = Auth::user()->sucursal_id;
        $compra->laboratorio_id = $request->laboratorio_id;
        $compra->save();

        $session_id = session()->getId();



        //registar en la caja 
        $caja_id = Caja::whereNull('fecha_cierre')->first();
        $movimiento = new MovimientoCaja();
        $movimiento->tipo = "EGRESO";
        $movimiento->monto = $request->precio_total;
        $movimiento->descripcion = "Compra de productos";
       
        $movimiento->fecha_movimiento = $request->fecha_movimiento ?? now();
        $movimiento->caja_id = $caja_id->id;// Ahora podemos estar más seguros de que no será null
        $movimiento->save(); 
        //


        // Redirigir al índice con un mensaje de éxito
       $tmp_compras = TmpCompra::where('session_id',$session_id)->get();

       foreach($tmp_compras as $tmp_compra){
//traer toda la informacion del producto
        $producto = Producto::where('id',$tmp_compra->producto_id)->first();
        $detalle_compra = new DetalleCompra();
        $detalle_compra->cantidad = $tmp_compra->cantidad;
     
        $detalle_compra->compra_id = $compra->id;
        $detalle_compra->producto_id = $tmp_compra->producto_id;
       
        $detalle_compra->save();

//SUMAR 
        $producto->stock += $tmp_compra->cantidad;
        $producto->save();




       }
       //QUE SE ELIMI LA TABLA DE TEMPORAL
       TmpCompra::where('session_id',$session_id)->delete();
       return redirect()->route('admin.compras.index')
       ->with('mensaje','Se registro el producto')
       ->with('icono','success');

       
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $compra = Compra::with('detalles','laboratorio')->findOrFail($id);
        return view('admin.compras.show',compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    
    
    {
    
        //
        $compra = Compra::with('detalles','laboratorio')->findOrFail($id);
        $laboratorios = Laboratorio::all();
        $productos = Producto::all();
        return view('admin.compras.edit',compact('compra','laboratorios','productos'));
    }
    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)

    {
         // Validación de los datos de entrada
         $request->validate([
        'fecha' => 'required',
        'comprobante' => 'required',
        'precio_total' => 'required', //
    ]);

    // Crear un nuevo laboratorio
    $compra = Compra::find($id);
    $compra->fecha = $request->fecha;
    $compra->comprobante = $request->comprobante;
    $compra->precio_total = $request->precio_total;

    $compra->sucursal_id = Auth::user()->sucursal_id;
    $compra->laboratorio_id = $request->laboratorio_id;
    $compra->save();

    $session_id = session()->getId();


      
    
        return redirect()->route('admin.compras.index')
        ->with('mensaje', 'Compra actualizada correctamente')
        ->with('icono','success');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $compra = Compra::with('detalles.producto')->findOrFail($id);
            
            // 1. Buscar el movimiento de caja relacionado (2 métodos alternativos)
            $movimiento = MovimientoCaja::where('descripcion', 'like', '%Compra de productos - ID: '.$compra->id.'%')
                                      ->orWhere('descripcion', 'like', '%Compra ID: '.$compra->id.'%')
                                      ->first();
            
            // Alternativa si lo anterior no funciona:
            if (!$movimiento) {
                $movimiento = MovimientoCaja::where('monto', $compra->precio_total)
                                          ->whereDate('created_at', $compra->created_at->toDateString())
                                          ->where('tipo', 'EGRESO')
                                          ->first();
            }
            
            // 2. Revertir stock de productos
            foreach ($compra->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->stock = max(0, $producto->stock - $detalle->cantidad); // Evita negativos
                $producto->save();
            }
            
            // 3. Eliminar en este orden
            if ($movimiento) {
                $movimiento->delete(); // Primero el movimiento
            }
            
            $compra->detalles()->delete(); // Luego los detalles
            $compra->delete(); // Finalmente la compra
            
            DB::commit();
            
            return redirect()->route('admin.compras.index')
                ->with('mensaje', 'Compra y movimiento de caja eliminados correctamente')
                ->with('icono', 'success');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('mensaje', 'Error al eliminar: '.$e->getMessage())
                ->with('icono', 'error');
        }
    }
    public function agregarTmp(Request $request)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|numeric|min:1'
    ]);

    // Verificar si ya existe
    $tmp = TmpCompra::where('user_id', auth()->id())
                   ->where('producto_id', $request->producto_id)
                   ->first();

    if ($tmp) {
        $tmp->cantidad += $request->cantidad;
        $tmp->save();
    } else {
        TmpCompra::create([
            'user_id' => auth()->id(),
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad
        ]);
    }

    return response()->json(['success' => true]);
}

public function eliminarTmp(Request $request)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id'
    ]);

    TmpCompra::where('user_id', auth()->id())
             ->where('producto_id', $request->producto_id)
             ->delete();

    return response()->json(['success' => true]);
}

public function actualizarTmp(Request $request)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|numeric|min:1'
    ]);

    TmpCompra::where('user_id', auth()->id())
             ->where('producto_id', $request->producto_id)
             ->update(['cantidad' => $request->cantidad]);

    return response()->json(['success' => true]);
}


public function reporte($tipo, Request $request)
{
    // Validar el tipo de reporte
    if (!in_array($tipo, ['pdf', 'excel', 'csv'])) {
        abort(400, 'Tipo de reporte no válido');
    }

    // Obtener filtros
    $fecha_inicio = $request->input('fecha_inicio');
    $fecha_fin = $request->input('fecha_fin');
    $laboratorio_id = $request->input('laboratorio_id');

    // Consulta base
    $query = Compra::with(['detalles', 'laboratorio'])
                  ->where('sucursal_id', Auth::user()->sucursal_id);

    // Aplicar filtros
    if ($fecha_inicio && $fecha_fin) {
        $query->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
    }

    if ($laboratorio_id) {
        $query->where('laboratorio_id', $laboratorio_id);
    }

    $compras = $query->get();

    // Verificar si hay datos
    if ($compras->isEmpty()) {
        return back()->with('error', 'No hay compras con los filtros seleccionados');
    }

    switch ($tipo) {
        case 'pdf':
            return $this->generarPDF($compras);
        case 'excel':
            return $this->generarExcel($compras);
        case 'csv':
            return $this->generarCSV($compras);
    }
}

private function generarPDF($compras)
{
    $pdf = PDF::loadView('admin.compras.reporte', [
        'compras' => $compras,
        'fecha_generacion' => now()->format('d/m/Y H:i:s')
    ])->setPaper('a4', 'landscape');
    
    return $pdf->download('reporte_compras_'.now()->format('YmdHis').'.pdf');
}

private function generarExcel($compras)
{
    $data = $compras->map(function ($compra) {
        return [
            'Fecha' => $compra->fecha,
            'Comprobante' => $compra->comprobante,
            'Laboratorio' => $compra->laboratorio->nombre,
            'Total' => $compra->precio_total,
            'Productos' => $compra->detalles->count(),
            'Cantidad Total' => $compra->detalles->sum('cantidad')
        ];
    });

    return Excel::download(
        new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection {
            private $data;
            public function __construct($data) { $this->data = $data; }
            public function collection() { return $this->data; }
        },
        'reporte_compras_'.now()->format('YmdHis').'.xlsx'
    );
}

private function generarCSV($compras): BinaryFileResponse
{
    return $this->generarExcel($compras)
        ->setContentDisposition('attachment', 'reporte_compras_'.now()->format('YmdHis').'.csv');
}



public function pdf($id) 
{
    try {
        // 1. Obtener datos básicos
        $id_sucursal = Auth::user()->sucursal_id;
        $sucursal = Sucursal::findOrFail($id_sucursal);
        
        // 2. Obtener la compra con relaciones (ajustado a tu estructura)
        $compra = Compra::with([
                'detalles.producto',  // Asegura la relación con productos
                'laboratorio'        // Relación con laboratorio
            ])
            ->where('sucursal_id', $id_sucursal)
            ->findOrFail($id);

        // 3. Convertir total a letras
        $literal = $this->numerosALetrasConDecimales($compra->precio_total);

        // 4. Generar PDF con datos específicos
        $pdf = PDF::loadView('admin.compras.pdf', [
            'sucursal' => $sucursal,
            'compra' => $compra,
            'literal' => $literal,
            'fecha_generacion' => now()->format('d/m/Y H:i') // Nuevo dato útil
        ])->setPaper([0, 0, 250.77, 600], 'portrait');

        // 5. Nombre descriptivo del archivo
        return $pdf->stream("compra-{$compra->comprobante}.pdf");

    } catch (\Exception $e) {
        Log::error("Error al generar PDF de compra: " . $e->getMessage());
        return redirect()->route('admin.compras.index')
            ->with('error', 'No se pudo generar el reporte: ' . $e->getMessage());
    }
}

// Función separada (puede estar en un trait o helper)
private function numerosALetrasConDecimales($numero) {
    $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    $partes = explode('.', number_format($numero, 2, '.', ''));
    $entero = $formatter->format($partes[0]);
    $decimal = $formatter->format($partes[1]);
    return ucfirst("$entero con $decimal/100");
}
}










