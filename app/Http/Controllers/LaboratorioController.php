<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class LaboratorioController extends Controller
{

    public function index()
    {
        $laboratorios = Laboratorio::all();//LISTA DE USUARIOS
        return view('admin.laboratorios.index',compact('laboratorios'));//ENVIARLOS DATOS ALA VISTA
    }


    public function create()
    {
        return view ('admin.laboratorios.create');
    }


    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            
            'nombre' => 'required',
            'telefono' => 'required',
            'direccion' => 'required', //
        ]);

        // Crear un nuevo laboratorio
        $laboratorio = new Laboratorio();
        $laboratorio->nombre = $request->nombre;
        $laboratorio->telefono = $request->telefono;
        $laboratorio->direccion = $request->direccion;
        $laboratorio->save();

        $laboratorio->assignRole($request->role);//asignar un rol

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.laboratorios.index')
            ->with('mensaje', 'Laboratorio creada con éxito.')
            ->with('icono', 'success');

    }

 
    public function show($id)
    {
        $laboratorio = Laboratorio::find($id); // buscar el laboratorio por ID
        
        return view('admin.laboratorios.show',compact('laboratorio')); // retornar vista de edición
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $laboratorio = Laboratorio::find($id); // buscar el laboratorio por ID
        
        return view('admin.laboratorios.edit',compact('laboratorio')); // retornar vista de edición
    }

    public function update(Request $request, $id)
    {
         //$datos =request()->all();
        //return response()->json($datos);
        // Validación de los datos de entrada
        $request->validate([
            'nombre' => 'required', // El nombre debe ser único, excepto para la categoría actual
            'telefono' => 'required',
            'direccion' => 'required',
    ]);

        // Buscar el laboratorio por ID
        $laboratorio = Laboratorio::find($id);

        // Actualizar los datos básicos
        $laboratorio->nombre = $request->nombre;
        $laboratorio->telefono = $request->telefono;
        $laboratorio->direccion = $request->direccion;
      
$laboratorio->save();
        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.laboratorios.index')
            ->with('mensaje','Se modifico la laboratorio')
            ->with('icono','success');
    
    }

    public function destroy($id)
    {
        Laboratorio::destroy($id); // Buscar el usuario por ID
      

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.laboratorios.index')
            ->with('mensaje', 'laboratorio eliminada con éxito.')
            ->with('icono', 'success');
    }
    public function listar()
{
    return Laboratorio::select('id', 'nombre', 'telefono')->get();
}
}
