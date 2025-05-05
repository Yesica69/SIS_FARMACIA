<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
   
    public function index()
    {
        $categorias = Categoria::all();//LISTA DE USUARIOS
        return view('admin.categorias.index',compact('categorias'));//ENVIARLOS DATOS ALA VISTA
    }

    
    public function create()
    {
        return view ('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            
            'nombre' => 'required|unique:categorias',
            'descripcion' => 'required', //
        ]);

        // Crear un nuevo categoria
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        $categoria->assignRole($request->role);//asignar un rol

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.categorias.index')
            ->with('mensaje', 'Categoria creada con éxito.')
            ->with('icono', 'success');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categoria = Categoria::find($id); // buscar el categoria por ID
        
        return view('admin.categorias.show',compact('categoria')); // retornar vista de edición
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoria = Categoria::find($id); // buscar el categoria por ID
        
        return view('admin.categorias.edit',compact('categoria')); // retornar vista de edición
    }

    public function update(Request $request, $id)
    {
         //$datos =request()->all();
        //return response()->json($datos);
        // Validación de los datos de entrada
        $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' .$id, // El nombre debe ser único, excepto para la categoría actual
            'descripcion' => 'required',
    ]);

        // Buscar el categoria por ID
        $categoria = Categoria::find($id);

        // Actualizar los datos básicos
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
      
$categoria->save();
        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.categorias.index')
            ->with('mensaje','Se modifico la categoria')
            ->with('icono','success');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Categoria::destroy($id); // Buscar el usuario por ID
      

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.categorias.index')
            ->with('mensaje', 'categoria eliminada con éxito.')
            ->with('icono', 'success');
    }
}
