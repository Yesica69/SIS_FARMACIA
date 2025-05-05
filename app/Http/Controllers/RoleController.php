<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf; 
use Spatie\Permission\Models\Permission; // al principio del controlador


use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get(); // importante
        $permisos = Permission::all();
    
        return view('admin.roles.index', compact('roles', 'permisos'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);

        $request->validate([
            
            'name'=>'required|unique:roles',
            
        ]);
        //
        $rol =new Role();
        $rol->name = $request->name;
        $rol->guard_name = "web";
        $rol->save();


        return redirect()->route('admin.roles.index')
        ->with('mensaje','Se registro el rol')
        ->with('icono','success');

            
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
{
    $role = Role::findOrFail($id);
    return view('admin.roles.edit', compact('role'));
}

public function update(Request $request, string $id)


{
    $request->validate([
        'name' => 'required|unique:roles,name,' . $id,
    ]);

    $role = Role::findOrFail($id);
    $role->name = $request->name;
    $role->save();

    return redirect()->route('admin.roles.index')
        ->with('mensaje', 'Rol actualizado con éxito')
        
        ->with('icono', 'success');
}



    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
{
    $role = Role::findOrFail($id);
    $role->delete();

    return redirect()->route('admin.roles.index')
        ->with('mensaje', 'Rol eliminado con éxito')
        ->with('icono', 'success');
}
public function reporte() {
    return view('admin.roles.reporte'); // Solo carga la vista, sin generar PDF
}

public function asignar($id){
    $rol = Role::find($id);
    $permisos = Permission::all();
    return view('admin.roles.index', compact('permisos', 'rol'));
}

public function update_asignar(Request $request, $id){
   // $datos = request()->all();
    //return response()->json($datos);


  
    // Encuentra el rol
    $rol = Role::find($id);

    $rol->permissions()->sync($request->input('permisos'));

    return redirect()->back()
        ->with('mensaje', 'Se asigno el permiso')
        
        ->with('icono', 'success');
}
}

