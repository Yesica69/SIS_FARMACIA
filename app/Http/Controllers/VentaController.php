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
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cajaAbierto = Caja::whereNull('fecha_cierre')->first();
        $ventas = Venta::with('detallesventa','cliente')->get();
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
        $movimiento->descripcion = "Venta de productos";
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
    public function destroy( $id)
    {
        //
        
        $venta = Venta::find($id);
        foreach ($venta->detallesVenta as $detalle){
            $producto = Producto::find($detalle->producto_id);
            $producto->stock += $detalle->cantidad;
            $producto->save();
        }
        $venta->detallesVenta()->delete();
        Venta::destroy($id);

        return redirect()->route('admin.ventas.index')
        ->with('mensaje', 'Se elimino la venta correctamente')
        ->with('icono','success');

    }
}
