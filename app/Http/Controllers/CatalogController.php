<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Sucursal;

use App\Models\Compra;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\DetalleVenta; // Asegúrate de importar el modelo DetalleVenta
use Illuminate\Support\Facades\DB; // Necesario para las consultas
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoriaId = $request->input('categoria');
        $sort = $request->input('sort', 'newest'); // Valor por defecto 'newest'
    
        // Consulta de productos más vendidos (se mantiene igual)
        $topProductos = DetalleVenta::join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->select(
                'productos.id',
                'productos.nombre',
                'productos.imagen',
                'productos.stock',
                'productos.precio_venta',
                DB::raw('SUM(detalle_ventas.cantidad) as total_vendido')
            )
            ->groupBy('productos.id', 'productos.nombre', 'productos.imagen', 'productos.stock','productos.precio_venta')
            ->orderByDesc('total_vendido')
            ->take(6)
            ->get();
    
        // Consulta base
        $query = Producto::with('categoria');
    
        // Aplicar filtros existentes
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('codigo', 'LIKE', "%{$search}%")
                  ->orWhereHas('categoria', function($q) use ($search) {
                      $q->where('nombre', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        if ($categoriaId) {
            $query->where('categoria_id', $categoriaId);
        }
    
        // Lógica de ordenamiento MEJORADA
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('precio_venta', 'asc');
                break;
                
            case 'price_desc':
                $query->orderBy('precio_venta', 'desc');
                break;
                
            case 'popular':
                $query->select('productos.*')
                     ->leftJoin('detalle_ventas', 'productos.id', '=', 'detalle_ventas.producto_id')
                     ->selectRaw('productos.*, SUM(IFNULL(detalle_ventas.cantidad, 0)) as total_vendido')
                     ->groupBy('productos.id')
                     ->orderByDesc('total_vendido');
                break;
                
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
        }
    
        $productos = $query->get();
    
        return view('admin.catalogo.index', [
            'productos' => $productos,
            'categorias' => Categoria::all(),
            'searchTerm' => $search,
            'topProductos' => $topProductos,
            'currentSort' => $sort
        ]);
    }
    public function show($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
    $categorias = Categoria::all(); // Agregado

    return view('admin.catalogo.show', compact('producto', 'categorias'));
    }

    public function ver(Categoria $categoria)
    {
       
        return view('admin.catalogo.ver', [ // Asegúrate que esta ruta coincida
            'productos' => $categoria->productos()->paginate(12),
            'categoria' => $categoria,
            'categorias' => Categoria::all()
        ]);
    }

    // En tu componente Livewire
public function getCategoryIcon($categoryName)
{
    $icons = [
        'Medicamentos' => 'fas fa-pills',
        'Cuidado Personal' => 'fas fa-spa',
        'Bebés' => 'fas fa-baby',
        'Vitaminas' => 'fas fa-apple-alt',
        'Dermocosmética' => 'fas fa-leaf',
        'Primeros Auxilios' => 'fas fa-first-aid',
        'Salud Sexual' => 'fas fa-heart',
        'Adultos Mayores' => 'fas fa-wheelchair'
    ];
    
    return $icons[$categoryName] ?? 'fas fa-tag';
}


// En tu controlador (CatalogoController.php)
public function buscar(Request $request)
{
    $request->validate(['search' => 'required|string|min:2']);
    
    $termino = $request->input('search');
    
    $productos = Producto::with('categoria')
        ->where('nombre', 'LIKE', "%{$termino}%")
        ->orWhere('descripcion', 'LIKE', "%{$termino}%")
        ->orWhereHas('categoria', function($query) use ($termino) {
            $query->where('nombre', 'LIKE', "%{$termino}%");
        })
        ->paginate(12);
    
    // Obtener todas las categorías para el filtro
    $categorias = Categoria::all(); // Asegúrate de importar el modelo Categoria
    
    return view('admin.catalogo.buscar', [
        'productos' => $productos,
        'terminoBusqueda' => $termino,
        'categorias' => $categorias // Pasamos las categorías a la vista
    ]);
}



// Ejemplo de controlador
// En tu controlador
// En tu controlador Laravel
public function search(Request $request)
{
    $query = $request->input('query', '');
    
    $results = Producto::where('nombre', 'like', "%$query%")
        ->take(10)
        ->get()
        ->map(function($item) {
            return [
                'nombre' => $item->nombre,
                'url' => route('admin.productos.show', $item->id),
                'imagen' => $item->imagen ? asset('storage/'.$item->imagen) : asset('img/default-product.png')
            ];
        });

    return response()->json($results);
}

}