<?php

namespace App\Http\Controllers;
use App\Models\Sucursal;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $proveedores = Proveedor::all();
        return view('admin.proveedores.index',compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos =request()->all();
        //return response()->json($datos);

        // Validación de los datos de entrada
        $request->validate([
            'empresa' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required',
            'nombre' => 'required',
            'celular' => 'required',
          
        ]);

        // Crear un nuevo proveedor
        $proveedor = new Proveedor();
        $proveedor->empresa = $request->empresa;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->nombre = $request->nombre;
        $proveedor->celular = $request->celular;
        $proveedor->sucursal_id = Auth::user()->sucursal_id;
        $proveedor->save();

        $proveedor->assignRole($request->role);//asignar un rol

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.proveedores.index')
            ->with('mensaje', 'S e registro al proveedor  con éxito.')
            ->with('icono', 'success');

    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        $proveedor = Proveedor::find($id); // buscar el proveedor por ID
        
        return view('admin.proveedores.show',compact('proveedor')); // retornar vista de edición
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $proveedor = Proveedor::find($id); // buscar el proveedor por ID
        
        return view('admin.proveedores.edit',compact('proveedor')); // retornar vista de edición

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Validación de los datos de entrada
        $request->validate([
            'empresa' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required',
            'nombre' => 'required',
            'celular' => 'required',
          
        ]);

        //  un nuevo proveedor
        $proveedor = Proveedor::find($id);
        $proveedor->empresa = $request->empresa;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->nombre = $request->nombre;
        $proveedor->celular = $request->celular;
        $proveedor->sucursal_id = Auth::user()->sucursal_id;
        $proveedor->save();

        $proveedor->assignRole($request->role);//asignar un rol

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.proveedores.index')
            ->with('mensaje', 'Se modifico al proveedor  con éxito.')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Proveedor::destroy($id); // Buscar el usuario por ID
      

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.proveedores.index')
            ->with('mensaje', 'se elimino al proveedor de manera correcta.')
            ->with('icono', 'success');
    }
}
