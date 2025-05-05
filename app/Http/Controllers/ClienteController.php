<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles; 
use Illuminate\Support\Facades\Auth; // Importar Auth

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clientes = Cliente::all();
        return view('admin.clientes.index',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view ('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         // Validación de los datos de entrada
         $request->validate([
            
            'nombre_cliente' => 'required',
            'nit_ci' => 'nullable',
            'celular' => 'nullable',
            'email' => 'nullable', //
        ]);

        // Crear un nuevo cliente
        $cliente = new Cliente();
        $cliente->nombre_cliente = $request->nombre_cliente;
        $cliente->nit_ci = $request->nit_ci;
        $cliente->celular = $request->celular;
        $cliente->email = $request->email;
        $cliente->sucursal_id = Auth::user()->sucursal_id;
        $cliente->save();

        $cliente->assignRole($request->role);//asignar un rol

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.clientes.index')
            ->with('mensaje', 'Cliente creada con éxito.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
        $cliente = Cliente::find($id); // buscar el cliente por ID
        
        return view('admin.clientes.show',compact('cliente')); // retornar vista de edició
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id); // buscar el cliente por ID
        
        return view('admin.clientes.edit',compact('cliente')); // retornar vista de edición
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
         //$datos =request()->all();
        //return response()->json($datos);
        // Validación de los datos de entrada
        $request->validate([
            'nombre_cliente' => 'required',
            'nit_ci' => 'nullable',
            'celular' => 'nullable',
            'email' => 'nullable',
    ]);

        // Buscar el cliente por ID
        $cliente = Cliente::find($id);

        // Actualizar los datos básicos
        $cliente->nombre_cliente = $request->nombre_cliente;
        $cliente->nit_ci = $request->nit_ci;
        $cliente->celular = $request->celular;
        $cliente->email = $request->email;
        $cliente->sucursal_id = Auth::user()->sucursal_id;
      
$cliente->save();
        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.clientes.index')
            ->with('mensaje','Se modifico la cliente')
            ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Cliente::destroy($id); // Buscar el usuario por ID
      

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.clientes.index')
            ->with('mensaje', 'Cliente eliminada con éxito.')
            ->with('icono', 'success');
    }
}
