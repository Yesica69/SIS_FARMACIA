<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Caja;
use App\Models\MovimientoCaja;
use App\Models\TmpCompra;
use App\Models\Proveedor;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importar Auth

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cajaAbierto = Caja::whereNull('fecha_cierre')->first();
        $compras = Compra::with(['detalles','laboratorio'])->get();

        
        return view('admin.compras.index', compact('compras','cajaAbierto'));
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
        //

        $compra = Compra::find($id);
        foreach ($compra->detalles as $detalle){
            $producto = Producto::find($detalle->producto_id);
            $producto->stock -= $detalle->cantidad;
            $producto->save();
        }
        $compra->detalles()->delete();
        Compra::destroy($id);

        return redirect()->route('admin.compras.index')
        ->with('mensaje', 'Se elimino la compra correctamente')
        ->with('icono','success');

    }
}
