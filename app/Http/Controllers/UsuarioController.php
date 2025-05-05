<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sucursal;
use App\Models\Role;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{

    public function index()
    {
        $sucursal_id = Auth::check() ? Auth::user()->sucursal_id : redirect()->route('login')->send();
        $usuarios = User::all()->map(function ($usuario) {
            $sucursal = Sucursal::find($usuario->sucursal_id);
            $usuario->sucursal_id = $sucursal->nombre;
            return $usuario;
        });

        $sucursales = Sucursal::all();
        $roles = Role::all();    // Lista de roles

        // Envía los datos a la vista
        return view('admin.usuarios.index', compact('usuarios', 'roles', 'sucursales'));

        $sucursal_id = Auth::user()->sucursal_id; // Obtener la sucursal del usuario autenticado
        $usuarios = User::where('sucursal_id', $sucursal_id)->get(); // Obtener usuarios de la misma sucursal

        return view('admin.usuarios.index', compact('usuarios'));


    }

    public function create()
    {

        $roles = Role::all(); // Cargamos todos los roles
        return view('admin.usuarios.create', compact('roles')); // Pasamos la variable roles a la vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validación de los datos de entrada
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',

        ]);

        // Crear un nuevo usuario
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->ci = $request->ci;

        $codigo = substr($request->name, 0, 3) . $request->ci;

        $usuario->password = Hash::make($codigo);
        $usuario->sucursal_id = $request->sucursal;

        $usuario->save();

        $usuario->assignRole($request->role);//asignar un rol

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Usuario creado con éxito.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::findOrFail($id); // Buscar el usuario por id
        return view('admin.usuarios.show', compact('usuario')); // retornar la vista para mostrar detalles del usuario
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id); // buscar el usuario por ID
        $role = Role::all(); // Obtener todos los roles
        return view('admin.usuarios.edit', compact('usuario', 'roles')); // retornar vista de edición
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación de los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // El correo debe ser único, excepto para el usuario actual
            'password' => 'confirmed'
        ]);

        // Buscar el usuario por ID
        $usuario = User::find($id);

        // Actualizar los datos básicos
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        // Actualizar la contraseña s
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        // Sincronizar el rol del usuario
        $usuario->syncRoles($request->role);

        // Guardar cambios
        $usuario->save();

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Se modifico el usuario')
            ->with('icono', 'success');

    }
    public function destroy(string $id)
    {
        User::destroy($id); // Buscar el usuario por ID


        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Usuario eliminado con éxito.')
            ->with('icono', 'success');
    }
}