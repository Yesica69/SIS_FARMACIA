<?php

namespace App\Http\Controllers;
use NumberToWords\NumberToWords;
use App\Models\Caja;
use NumberFormatter;


use App\Models\Venta;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Sucursal;
use App\Models\Producto;

use App\Models\MovimientoCaja;
use Illuminate\Http\Request;
use App\Models\TmpVenta;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; // ¡Este es el import que faltaba!
use Illuminate\Support\Facades\Log; 


use Illuminate\Support\Facades\Storage;


use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use DatePeriod; // Importación añadida
use DateInterval; // Importación añadida
use DateTime; // Importación añadida
// Asegúrate de tener este modelo para acceder a los datos de ingresos

use Symfony\Component\HttpFoundation\BinaryFileResponse;
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cajaAbierto = Caja::whereNull('fecha_cierre')->first();
        $ventas = Venta::with('detallesventa','cliente')
        ->orderBy('fecha', 'desc')  // Ordenar por fecha descendente
                ->get();
        return view('admin.ventas.index',compact('ventas','cajaAbierto'));

       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $productos = Producto::where('sucursal_id', Auth::user()->sucursal_id)->get();
        //   $proveedores = Proveedor::where('sucursal_id', Auth::user()->sucursal_id)->get();
        $clientes = cliente::where('sucursal_id', Auth::user()->sucursal_id)->get();
       $session_id = session()->getId();
       $tmp_ventas = TmpVenta::where('session_id',$session_id)->get();
        return view('admin.ventas.create',compact('productos','clientes','tmp_ventas'));
    }



    public function cliente_store(Request $request){
        $validate = $request->validate ([
            'nombre_cliente' => 'required',
            'nit_ci' => 'nullable',
            'celular' => 'nullable',
            'email' => 'nullable',
        ]);
            // Crear un nuevo cliente
       $cliente = new Cliente();
       $cliente->nombre_cliente = $request->nombre_cliente;
       $cliente->nit_ci = $request->nit_ci;
       $cliente->celular = $request->celular;
       $cliente->email = $request->email;
       $cliente->sucursal_id = Auth::user()->sucursal_id;
       $cliente->save();
       return response()->json(['success'=>'cliente registrado']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //$datos =request()->all();
        //return response()->json($datos);

            // Validación de los datos de entrada
            $request->validate([
                        
                'fecha' => 'required',
              
                'precio_total' => 'required', //
            ]);
            

            // Crear un nuevo laboratorio
            $ventas = new Venta();
            $ventas->fecha = $request->fecha;
            
            $ventas->precio_total = $request->precio_total;

            $ventas->sucursal_id = Auth::user()->sucursal_id;
            $ventas->cliente_id = $request->cliente_id;
            $ventas->save();

            $session_id = session()->getId();


                    //registar en la caja 
        $caja_id = Caja::whereNull('fecha_cierre')->first();
        $movimiento = new MovimientoCaja();
        $movimiento->tipo = "INGRESO";
        $movimiento->monto = $request->precio_total;
       
        $movimiento->descripcion = "venta de productos";
        $movimiento->fecha_movimiento = $request->fecha_movimiento ?? now();
        $movimiento->caja_id = $caja_id->id;// Ahora podemos estar más seguros de que no será null
        $movimiento->save(); 
        //




            // Redirigir al índice con un mensaje de éxito
            $tmp_ventas = TmpVenta::where('session_id',$session_id)->get();

            foreach($tmp_ventas as $tmp_venta){
            //traer toda la informacion del producto
            $producto = Producto::where('id',$tmp_venta->producto_id)->first();
            $detalle_venta = new DetalleVenta();
            $detalle_venta->cantidad = $tmp_venta->cantidad;

            $detalle_venta->venta_id = $ventas->id;
            $detalle_venta->producto_id = $tmp_venta->producto_id;

            $detalle_venta->save();

            //SUMAR 
            $producto->stock -= $tmp_venta->cantidad;
            $producto->save();




            }
            //QUE SE ELIMI LA TABLA DE TEMPORAL
            TmpVenta::where('session_id',$session_id)->delete();
            return redirect()->route('admin.ventas.index')
            ->with('mensaje','Se registro la venta')
            ->with('icono','success');



    }
public function pdf($id){





    function numerosALetrasConDecimales($numero) 
    {
        $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    
        // Asegurar que el número tenga 2 decimales
        $partes = explode('.', number_format($numero, 2, '.', ''));
    
        // Convertir las partes a enteros
        $entero = $formatter->format($partes[0]);
        $decimal = $formatter->format($partes[1]);
    
        return ucfirst("$entero con $decimal/100");
    }
    




    $id_sucursal = Auth::user()->sucursal_id;
    $sucursal =Sucursal::where('id',$id_sucursal)->first();
    $venta = Venta::with('detallesVenta','cliente')->findOrfail($id);
//convertir
    $numero = $venta->precio_total;
$literal = numerosALetrasConDecimales($numero);





$pdf = PDF::loadView('admin.ventas.pdf', compact('sucursal', 'venta', 'literal'))
          ->setPaper([0, 0, 250.77, 600], 'portrait'); // 80mm ancho x 600pt alto (ajustable)

return $pdf->stream();

  //  return view('admin.ventas.pdf');

}


function numerosALetrasConDecimales($numero) 
{
    $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);

    // Asegurar que el número tenga 2 decimales
    $partes = explode('.', number_format($numero, 2, '.', ''));

    // Convertir las partes a enteros
    $entero = $formatter->format((int) $partes[0]);
    $decimal = str_pad($partes[1], 2, "0", STR_PAD_LEFT);

    return ucfirst("$entero con $decimal/100");
}









    public function show( $id)
    {
        //
        $venta = Venta::with('detallesVenta','cliente')->findOrfail($id);
        return view('admin.ventas.show',compact('venta'));

    }

    public function edit( $id)
    {
        //
        $productos = Producto::all();
        $clientes = Cliente::all();
        $venta = Venta::with('detallesVenta','cliente')->findOrfail($id);
        return view('admin.ventas.edit',compact('venta','productos','clientes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
         // Validación de los datos de entrada
         $request->validate([
            'fecha' => 'required',

            'precio_total' => 'required', //
        ]);
    
        // Crear un nuevo laboratorio
        $venta = Venta::find($id);
        $venta->fecha = $request->fecha;
    
        $venta->precio_total = $request->precio_total;
    
        $venta->sucursal_id = Auth::user()->sucursal_id;
        $venta->cliente_id = $request->cliente_id;
        $venta->save();
    
        $session_id = session()->getId();
    
    
          
        
            return redirect()->route('admin.ventas.index')
            ->with('mensaje', 'Venta actualizada correctamente')
            ->with('icono','success');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    DB::beginTransaction();
    try {
        $venta = Venta::with('detallesVenta.producto')->findOrFail($id);
        
        // 1. Búsqueda exacta del movimiento de caja
        $movimiento = MovimientoCaja::where('descripcion', 'Venta ID: '.$venta->id)
                                  ->first();
        
        // 2. Si no se encuentra, buscar por monto y fecha exacta
        if (!$movimiento) {
            $movimiento = MovimientoCaja::where('monto', $venta->precio_total)
                                      ->whereDate('created_at', $venta->created_at->toDateString())
                                      ->where('tipo', 'INGRESO')
                                      ->first();
        }
        
        // 3. Debug: Verificar datos de búsqueda
        Log::info('Datos de búsqueda para venta ID: '.$venta->id, [
            'descripcion_buscada' => 'Venta ID: '.$venta->id,
            'precio_total' => $venta->precio_total,
            'fecha_venta' => $venta->created_at,
            'movimiento_encontrado' => $movimiento ? $movimiento->toArray() : null
        ]);
        
        // 4. Revertir stock de productos
        foreach ($venta->detallesVenta as $detalle) {
            $producto = $detalle->producto;
            $producto->stock += $detalle->cantidad;
            $producto->save();
        }
        
        // 5. Eliminar movimiento si existe
        if ($movimiento) {
            $movimiento->delete();
            Log::info("Movimiento eliminado: ".$movimiento->id);
        } else {
            Log::warning("No se encontró movimiento para venta ID: ".$venta->id);
        }
        
        // 6. Eliminar detalles y venta
        $venta->detallesVenta()->delete();
        $venta->delete();
        
        DB::commit();
        
        return redirect()->route('admin.ventas.index')
            ->with('mensaje', 'Venta eliminada correctamente')
            ->with('icono', 'success');
            
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Error eliminando venta ID {$id}: ".$e->getMessage());
        return redirect()->back()
            ->with('mensaje', 'Error al eliminar: '.$e->getMessage())
            ->with('icono', 'error');
    }
}

//reportes

public function reporte($tipo, Request $request)
{
    // Validar el tipo de reporte
    if (!in_array($tipo, ['pdf', 'excel', 'csv'])) {
        abort(400, 'Tipo de reporte no válido');
    }

    // Obtener filtros
    $fecha_inicio = $request->input('fecha_inicio');
    $fecha_fin = $request->input('fecha_fin');
    $cliente_id = $request->input('cliente_id');

    // Consulta base
    $query = Venta::with(['detallesVenta', 'cliente'])
                ->where('sucursal_id', Auth::user()->sucursal_id);

    // Aplicar filtros
    if ($fecha_inicio && $fecha_fin) {
        $query->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);
    }

    if ($cliente_id) {
        $query->where('cliente_id', $cliente_id);
    }

    $ventas = $query->get();

    // Verificar si hay datos
    if ($ventas->isEmpty()) {
        return back()->with('error', 'No hay ventas con los filtros seleccionados');
    }

    switch ($tipo) {
        case 'pdf':
            return $this->generarPDF($ventas);
        case 'excel':
            return $this->generarExcel($ventas);
        case 'csv':
            return $this->generarCSV($ventas);
    }
}

private function generarPDF($ventas)
{
    $pdf = PDF::loadView('admin.ventas.reporte', [
        'ventas' => $ventas,
        'fecha_generacion' => now()->format('d/m/Y H:i:s')
    ])->setPaper('a4', 'landscape');
    
    return $pdf->download('reporte_ventas_'.now()->format('YmdHis').'.pdf');

    
}

private function generarExcel($ventas)
{
    $data = $ventas->map(function ($venta) {
        return [
            'Fecha' => $venta->fecha,
            'Cliente' => $venta->cliente->nombre_cliente ?? 'Sin cliente',
            'Total' => $venta->precio_total,
            'Productos' => $venta->detallesVenta->count(),
            'Cantidad Total' => $venta->detallesVenta->sum('cantidad')
        ];
    });

    return Excel::download(
        new class($data) implements FromCollection {
            private $data;
            public function __construct($data) { $this->data = collect($data); }
            public function collection() { return $this->data; }
        },
        'reporte_ventas_'.now()->format('YmdHis').'.xlsx'
    );
}

private function generarCSV($ventas): BinaryFileResponse
{
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="reporte_ventas_'.now()->format('YmdHis').'.csv"',
    ];

    $callback = function() use ($ventas) {
        $file = fopen('php://output', 'w');
        
        // Encabezados
        fputcsv($file, ['Fecha', 'Cliente', 'Total', 'Productos', 'Cantidad Total']);
        
        // Datos
        foreach ($ventas as $venta) {
            fputcsv($file, [
                $venta->fecha,
                $venta->cliente->nombre_cliente ?? 'Sin cliente',
                $venta->precio_total,
                $venta->detallesVenta->count(),
                $venta->detallesVenta->sum('cantidad')
            ]);
        }
        
        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}





}
