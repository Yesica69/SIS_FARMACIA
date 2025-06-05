<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Sucursal;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\DetalleVenta; // Asegúrate de importar el modelo DetalleVenta
use Illuminate\Support\Facades\DB; // Necesario para las consultas
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
 

public function index()
{
    $total_productos = Producto::count();
    $total_compras = Compra::count();
    $total_clientes = Cliente::count();
    $compras = Compra::count();
    $total_ventas = Venta::count();

    $sucursal_id = Auth::check() ? Auth::user()->sucursal_id : redirect()->route('login')->send();
    $sucursal = Sucursal::where('id', $sucursal_id)->first();

    // Productos más vendidos
    $topProducts = DetalleVenta::join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
        ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
        ->where('ventas.sucursal_id', $sucursal_id)
        ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as total_vendido'))
        ->groupBy('productos.nombre')
        ->orderBy('total_vendido', 'DESC')
        ->take(5)
        ->get();
          // Preparar datos para la gráfica
    $labels = $topProducts->pluck('nombre');
    $data = $topProducts->pluck('total_vendido');

    // Productos con bajo stock (menos de 10 unidades)
    $lowStockProducts = Producto::where('stock', '<', 4)
        ->where('sucursal_id', $sucursal_id)
        ->orderBy('stock', 'ASC')
        ->get();

    

    return view('pages.dashboard', compact(
        'sucursal',
        'total_productos',
        'total_compras',
        'total_clientes',
        'total_ventas',
        'compras',
        'labels',
        'data',
        'topProducts',
        'lowStockProducts'
    ));
}}