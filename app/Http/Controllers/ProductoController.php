<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use App\Models\Laboratorio;  
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
  
    public function index()
    {
        

        $productos = Producto::with('categoria', 'laboratorio')->get();
        $categorias = Categoria::all(); // Asegura que se pase a la vista correcta
        $laboratorios = Laboratorio::all();
        
        return view('admin.productos.index', compact('productos', 'categorias','laboratorios'));
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $laboratorios = Laboratorio::all();
        $categorias = Categoria::all();  // Obtener todas las categorías
        return view('admin.productos.create', compact('categorias','laboratorios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $datos = request()->all();
        //return response()->json($datos);
//VALIDACION DE LOS DATOS DE ENTRDAD
        $request->validate([
            'codigo'=>'required|unique:productos,codigo',
            'nombre'=>'required',
            'stock'=>'required',
            'stock_minimo'=>'required',
            'stock_maximo'=>'required',
            'precio_compra'=>'required',
            'precio_venta'=>'required',
            'descripcion'=>'required',
            'fecha_ingreso'=>'required',
            'fecha_vencimiento' => 'nullable|date', // No es obligatorio
            
            'imagen'=>'required|image|mimes:jpg, jpeg,png',
            
        ]);
        //nuevo procuctos
        $producto = new Producto();
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->stock_maximo = $request->stock_maximo;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->fecha_ingreso = $request->fecha_ingreso;
        $producto->fecha_vencimiento = $request->fecha_vencimiento;
        $producto->categoria_id = $request->categoria_id;
        $producto->laboratorio_id = $request->laboratorio_id;
        $producto->sucursal_id = Auth::user()->sucursal_id;
        //SI HAY UNA IMAGEN Q 
        if($request->hasFile('imagen')){
            //SE ELIMINA DE LA CARPETA
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
            
        }

        $producto->save();
        
        return redirect()->route('admin.productos.index')
        ->with('mensaje','Se registro el producto')
        ->with('icono','success');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::findOrFail($id); // Buscar el usuario por id
        return view('admin.productos.show', compact('producto')); // retornar la vista para mostrar detalles del usuario
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
{
    $producto = Producto::find($id);
    $categorias = Categoria::all(); // Esto obtiene todas las categorías
    return view('admin.productos.edit', compact('producto', 'categorias')); // Se pasan ambas variables a la vista
}

    public function update(Request $request, $id)
    {
        // $datos = request()->all();
        //return response()->json($datos);

        //VALIDACION DE LOS DATOS DE ENTRDAD
        $request->validate([
            'codigo' => 'required|unique:productos,codigo,' . $id,
            'nombre' => 'required',
            'stock' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'stock_maximo' => 'required|integer',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'descripcion' => 'required',
            'fecha_ingreso' => 'required|date',
            'fecha_vencimiento' => 'nullable|date', // No es obligatorio
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png', // Hacer la imagen opcional
        ]);
        


        //reemplazar procuctos
        $producto = Producto::find($id);
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->stock_maximo = $request->stock_maximo;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->fecha_ingreso = $request->fecha_ingreso;
        $producto->fecha_vencimiento = $request->fecha_vencimiento;
        $producto->categoria_id = $request->categoria_id;
        $producto->laboratorio_id = $request->laboratorio_id;

     //SI HAY UNA IMAGEN Q 
     if($request->hasFile('imagen')){
        //SE ELIMINA DE LA CARPETA
        Storage::delete('public/'.$producto->imagen);

    $producto->imagen = $request->file('imagen')->store('productos', 'public');
    }

        $producto->save();
        
        return redirect()->route('admin.productos.index')
        ->with('mensaje','Se actualizo el producto')
        ->with('icono','success');

    }

  
    public function destroy($id)
    {
        $producto = Producto::find($id);
        Storage::delete('public/'.$producto->imagen);
        Producto::destroy($id); // Buscar el usuario por ID

      

        // Redirigir al índice con un mensaje de éxito
        return redirect()->route('admin.productos.index')
            ->with('mensaje', 'Se elimino con éxito.')
            ->with('icono', 'success');
    }
}
