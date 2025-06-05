<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use App\Models\Laboratorio;  
use Illuminate\Support\Facades\Auth;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use DatePeriod; // Importación añadida
use DateInterval; // Importación añadida
use DateTime; // Importación añadida
// Asegúrate de tener este modelo para acceder a los datos de ingresos
use PDF; 
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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
    public function buscar(Request $request)
    {
        $term = $request->input('term');
        
        $productos = Producto::where('codigo', 'like', "%$term%")
                    ->orWhere('nombre', 'like', "%$term%")
                    ->select('id', 'codigo', 'nombre', 'descripcion')
                    ->limit(10)
                    ->get();
        
        return response()->json($productos);
    }

    public function get($id)
{
    $producto = Producto::find($id);
    
    if($producto) {
        return response()->json([
            'success' => true,
            'producto' => $producto
        ]);
    }
    
    return response()->json(['success' => false]);
}


 public function generarReporte($tipo, Request $request)
    {
        // Validación del tipo de reporte
        if (!in_array($tipo, ['pdf', 'excel', 'csv'])) {
            abort(400, 'Tipo de reporte no válido');
        }

        // Obtener y procesar filtros
        $filtros = $this->procesarFiltros($request);

        // Obtener productos con filtros aplicados
        $productos = $this->obtenerProductosFiltrados($filtros);

        // Verificar si hay datos
        if ($productos->isEmpty()) {
            return back()->with('error', 'No hay productos con los filtros seleccionados');
        }

        // Convertir fechas a objetos Carbon
        $productos = $this->convertirFechas($productos);

        // Generar el reporte según el tipo
        return $this->generarReportePorTipo($tipo, $productos);
    }

    protected function procesarFiltros(Request $request): array
    {
        return [
            'categoria_id' => $request->input('categoria'),
            'stockBajo' => $request->input('stockBajo', 0),
            'diasVencimiento' => $request->input('diasVencimiento')
        ];
    }

    protected function obtenerProductosFiltrados(array $filtros)
    {
        $query = Producto::with('categoria', 'laboratorio')
                        ->where('sucursal_id', Auth::user()->sucursal_id);

        if ($filtros['categoria_id']) {
            $query->where('categoria_id', $filtros['categoria_id']);
        }

        if ($filtros['stockBajo']) {
            $query->where('stock', '<', \DB::raw('stock_minimo'));
        }

        if ($filtros['diasVencimiento']) {
            $fechaVencimiento = now()->addDays($filtros['diasVencimiento']);
            $query->whereDate('fecha_vencimiento', '<=', $fechaVencimiento)
                  ->whereNotNull('fecha_vencimiento');
        }

        return $query->get();
    }

    protected function convertirFechas($productos)
    {
        return $productos->map(function ($producto) {
            $producto->fecha_ingreso = Carbon::parse($producto->fecha_ingreso);
            $producto->fecha_vencimiento = $producto->fecha_vencimiento 
                ? Carbon::parse($producto->fecha_vencimiento) 
                : null;
            return $producto;
        });
    }

    protected function generarReportePorTipo($tipo, $productos)
    {
        switch ($tipo) {
            case 'pdf':
                return $this->generarPDF($productos);
            case 'excel':
                return $this->generarExcel($productos);
            case 'csv':
                return $this->generarCSV($productos);
        }
    }

    private function generarPDF($productos)
    {
        $pdf = PDF::loadView('admin.productos.reporte', [
            'productos' => $productos,
            'fecha_generacion' => now()->format('d/m/Y H:i:s'),
            'page' => 1, 
             'pages' => 1
        ]);
        
        return $pdf->download('reporte_productos_'.now()->format('YmdHis').'.pdf');
    }

    private function generarExcel($productos)
    {
        $data = $productos->map(function ($producto) {
            return [
                'Código' => $producto->codigo,
                'Nombre' => $producto->nombre,
                'Descripción' => $producto->descripcion,
                'Categoría' => $producto->categoria->nombre,
                'Laboratorio' => $producto->laboratorio->nombre,
                'Stock' => $producto->stock,
                'Stock Mínimo' => $producto->stock_minimo,
                'Stock Máximo' => $producto->stock_maximo,
                'Precio Compra' => $producto->precio_compra,
                'Precio Venta' => $producto->precio_venta,
                'Fecha Ingreso' => $producto->fecha_ingreso->format('d/m/Y'),
                'Fecha Vencimiento' => $producto->fecha_vencimiento?->format('d/m/Y') ?? 'N/A',
                
            ];
        });

        return Excel::download(
            new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection {
                private $data;
                public function __construct($data) { $this->data = $data; }
                public function collection() { return $this->data; }
            },
            'reporte_productos_'.now()->format('YmdHis').'.xlsx'
        );
    }

    private function generarCSV($productos): BinaryFileResponse
    {
        return $this->generarExcel($productos)
            ->setContentDisposition('attachment', 'reporte_productos_'.now()->format('YmdHis').'.csv');
    }
}
