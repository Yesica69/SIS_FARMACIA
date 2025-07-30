<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permission::all();
        return view('admin.permisos.index',compact('permisos'));
    }


    public function store(Request $request)
    {
               //$datos = request()->all();
        //return response()->json($datos);
        // Validación de los datos de entrada
        $request->validate([
                    
            'name' => 'required|unique:permissions,name',
            
        ]);

        Permission::create(['name'=>$request->name]);

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.permisos.index')
        ->with('mensaje', 'Se registro el permiso de la manera correcta')
        ->with('icono', 'success');

    }

    public function show($id){
$permiso = Permission::find($id);
        return view('admin.permisos.show',compact('permiso'));
    }


    public function edit(string $id)
    {
        $permiso = Permission::find($id);
        return view('admin.permisos.edit', compact('permiso'));
    }
    
    public function update(Request $request, string $id)
    
    
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
        ]);
    
        $permiso = Permission::find($id);
        $permiso->update(['name'=>$request->name]);
        $permiso->save();
    
        return redirect()->route('admin.permisos.index')
            ->with('mensaje', 'Permiso actualizado con éxito')
            
            ->with('icono', 'success');
    }
    
    
    
        /**
         * Remove the specified resource from storage.
         */
    
        public function destroy(string $id)
    {
        $permiso = Permission::findOrFail($id);
        $permiso->delete();
    
        return redirect()->route('admin.permisos.index')
            ->with('mensaje', 'Permiso eliminado con éxito')
            ->with('icono', 'success');
    }
}
