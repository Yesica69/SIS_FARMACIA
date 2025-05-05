<?php

namespace App\Http\Controllers;


use App\Models\Caja;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\Sucursal;
use App\Models\MovimientoCaja;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

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


    

 

}
