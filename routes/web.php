<?php

use Illuminate\Support\Facades\Route;

// Redirigir automáticamente la ruta /home a /admin
Route::get('/home', function () {
    return redirect('/admin');
})->name('home');

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;          
use App\Http\Controllers\SucursalController;

            

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static'); 
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static'); 
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});











// En routes/web.php
Route::prefix('admin/sucursals')->group(function () {
    Route::get('/', [SucursalController::class, 'index'])->name('admin.sucursals.index');
    Route::get('/crear', [SucursalController::class, 'create'])->name('admin.sucursals.create');
    Route::post('/guardar', [SucursalController::class, 'store'])->name('admin.sucursals.store');
    Route::get('/editar/{id}', [SucursalController::class, 'edit'])->name('admin.sucursals.edit');
    Route::put('/actualizar/{id}', [SucursalController::class, 'update'])->name('admin.sucursals.update');
    Route::delete('/eliminar/{id}', [SucursalController::class, 'destroy'])->name('admin.sucursals.destroy');
    Route::get('/admin/sucursals/reporte', [SucursalController::class, 'generarReporte'])
     ->name('admin.sucursals.reporte');
});


   
// Elimina el {tipo} de la URI
//rutas para roles
 Route::get('/admin/roles/reporte', [App\Http\Controllers\RoleController::class, 'generarReporte'])
     ->name('admin.roles.reporte');
Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth');
Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create');
Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store');
Route::get('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('admin.roles.show')->middleware('auth');
Route::get('/admin/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth');
Route::put('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth');
Route::delete('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth');

 

   

//ruta apara asignar prmiso
Route::get('/admin/roles/{id}/asignar', [App\Http\Controllers\RoleController::class, 'asignar'])->name('admin.roles.asignar')->middleware('auth');
Route::put('/admin/roles/asignar/{id}', [App\Http\Controllers\RoleController::class, 'update_asignar'])->name('admin.roles.update_asignar')->middleware('auth');
// Rutas para USUARIOS
Route::get('/management', [App\Http\Controllers\UserProfileController::class, 'index'])
     ->name('management.index')->middleware('auth');

Route::get('/management/create', [App\Http\Controllers\UserProfileController::class, 'create'])
     ->name('management.create')->middleware('auth');

Route::post('/management/create', [App\Http\Controllers\UserProfileController::class, 'store'])
     ->name('management.store')->middleware('auth');

Route::get('/management/{id}', [App\Http\Controllers\UserProfileController::class, 'show'])
     ->name('management.show')->middleware('auth');

Route::get('/management/{id}/edit', [App\Http\Controllers\UserProfileController::class, 'edit'])
     ->name('management.edit')->middleware('auth');  // Corregido a 'management.edit'

Route::put('/management/{id}', [App\Http\Controllers\UserProfileController::class, 'update'])
     ->name('management.update')->middleware('auth');

Route::delete('/management/{id}', [App\Http\Controllers\UserProfileController::class, 'destroy'])
     ->name('management.destroy')->middleware('auth');

//rutas para USUARIOS

Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware('auth');
Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware('auth');
Route::post('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware('auth');
Route::get('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware('auth');
Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware('auth');
Route::put('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware('auth');
Route::delete('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware('auth');

Route::get('/admin/usuarios/reporte/{tipo}', [App\Http\Controllers\UsuarioController::class, 'generarReporte'])
    ->where('tipo', 'pdf|excel|csv|print')
    ->name('admin.usuarios.reporte');


//rutas para CATEGORIAS

Route::get('/admin/categorias/reporte', [App\Http\Controllers\CategoriaController::class, 'generarReporte'])
     ->name('admin.categorias.reporte');
Route::get('/admin/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('admin.categorias.index')->middleware('auth');
Route::get('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('admin.categorias.create')->middleware('auth');
Route::post('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'store'])->name('admin.categorias.store')->middleware('auth');
Route::get('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('admin.categorias.show')->middleware('auth');
Route::get('/admin/categorias/{id}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('admin.categorias.edit')->middleware('auth');
Route::put('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('admin.categorias.update')->middleware('auth');
Route::delete('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('admin.categorias.destroy')->middleware('auth');

     

//RUTAS PARA LABORATORIOS
 Route::get('/admin/laboratorios/reporte', [App\Http\Controllers\LaboratorioController::class, 'generarReporte'])
     ->name('admin.laboratorios.reporte');
Route::get('/admin/laboratorios', [App\Http\Controllers\LaboratorioController::class, 'index'])->name('admin.laboratorios.index')->middleware('auth');
Route::get('/admin/laboratorios/create', [App\Http\Controllers\LaboratorioController::class, 'create'])->name('admin.laboratorios.create')->middleware('auth');
Route::post('/admin/laboratorios/create', [App\Http\Controllers\LaboratorioController::class, 'store'])->name('admin.laboratorios.store')->middleware('auth');
Route::get('/admin/laboratorios/{id}', [App\Http\Controllers\LaboratorioController::class, 'show'])->name('admin.laboratorios.show')->middleware('auth');
Route::get('/admin/laboratorios/{id}/edit', [App\Http\Controllers\LaboratorioController::class, 'edit'])->name('admin.laboratorios.edit')->middleware('auth');
Route::put('/admin/laboratorios/{id}', [App\Http\Controllers\LaboratorioController::class, 'update'])->name('admin.laboratorios.update')->middleware('auth');
Route::delete('/admin/laboratorios/{id}', [App\Http\Controllers\LaboratorioController::class, 'destroy'])->name('admin.laboratorios.destroy')->middleware('auth');


//RUTAS PARA PRODUCTOS

    Route::get('/admin/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('admin.productos.index')->middleware('auth');
    Route::get('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('admin.productos.create')->middleware('auth');
    Route::post('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'store'])->name('admin.productos.store')->middleware('auth');
    Route::get('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'show'])->name('admin.productos.show')->middleware('auth');
    Route::get('/admin/productos/{id}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])->name('admin.productos.edit')->middleware('auth');
    Route::put('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('admin.productos.update')->middleware('auth');
    Route::delete('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('admin.productos.destroy')->middleware('auth');




     Route::get('/admin/productos/reporte/{tipo}', [App\Http\Controllers\ProductoController::class, 'generarReporte'])
     ->where('tipo', 'pdf|excel|csv')
     ->name('admin.productos.reporte');


    //RUTAS PARA PROVEEDOR
 Route::get('/admin/proveedores/reporte', [App\Http\Controllers\ProveedorController::class, 'generarReporte'])
     ->name('admin.proveedores.reporte');
    Route::get('/admin/proveedores', [App\Http\Controllers\ProveedorController::class, 'index'])->name('admin.proveedores.index')->middleware('auth');
    Route::get('/admin/proveedores/create', [App\Http\Controllers\ProveedorController::class, 'create'])->name('admin.proveedores.create')->middleware('auth');
    Route::post('/admin/proveedores/create', [App\Http\Controllers\ProveedorController::class, 'store'])->name('admin.proveedores.store')->middleware('auth');
    Route::get('/admin/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'show'])->name('admin.proveedores.show')->middleware('auth');
    Route::get('/admin/proveedores/{id}/edit', [App\Http\Controllers\ProveedorController::class, 'edit'])->name('admin.proveedores.edit')->middleware('auth');
    Route::put('/admin/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'update'])->name('admin.proveedores.update')->middleware('auth');
    Route::delete('/admin/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'destroy'])->name('admin.proveedores.destroy')->middleware('auth');


       //RUTAS PARA COMPRAS

       Route::get('/admin/compras', [App\Http\Controllers\CompraController::class, 'index'])->name('admin.compras.index')->middleware('auth');
       Route::get('/admin/compras/create', [App\Http\Controllers\CompraController::class, 'create'])->name('admin.compras.create')->middleware('auth');
       Route::post('/admin/compras/create', [App\Http\Controllers\CompraController::class, 'store'])->name('admin.compras.store')->middleware('auth');
       Route::get('/admin/compras/{id}', [App\Http\Controllers\CompraController::class, 'show'])->name('admin.compras.show')->middleware('auth');
       Route::get('/admin/compras/{id}/edit', [App\Http\Controllers\CompraController::class, 'edit'])->name('admin.compras.edit')->middleware('auth');
       Route::put('/admin/compras/{id}', [App\Http\Controllers\CompraController::class, 'update'])->name('admin.compras.update')->middleware('auth');
       Route::delete('/admin/compras/{id}', [App\Http\Controllers\CompraController::class, 'destroy'])->name('admin.compras.destroy')->middleware('auth');
   
  Route::get('/admin/compras/reporte/{tipo}', [App\Http\Controllers\CompraController::class, 'reporte'])
     ->where('tipo', 'pdf|excel|csv')
     ->name('admin.compras.reporte');


     Route::get('/admin/compras/pdf/{id}', [App\Http\Controllers\CompraController::class, 'pdf'])->name('admin.compras.pdf')->middleware('auth');
       //tmp
       Route::post('/admin/compras/create/tmp', [App\Http\Controllers\TmpCompraController::class, 'tmp_compras'])->name('admin.compras.tmp_compras')->middleware('auth');
       Route::delete('/admin/compras/create/tmp/{id}', [App\Http\Controllers\TmpCompraController::class, 'destroy'])->name('admin.compras.tmp_compras.destroy')->middleware('auth');
       

       //ruta para detalles de la compra
       Route::post('/admin/compras/detalle/create', [App\Http\Controllers\DetalleCompraController::class, 'store'])->name('admin.detalle.compras.store')->middleware('auth');
       Route::delete('/admin/compras/detalle/{id}', [App\Http\Controllers\DetalleCompraController::class, 'destroy'])->name('admin.detalle.compras.destroy')->middleware('auth');

// routes/lote
Route::post('/admin/compras/agregar-lote', [App\Http\Controllers\CompraController::class, 'agregarLote'])->name('compras.agregarLote');

Route::get('/admin/compras/tmp', [App\Http\Controllers\CompraController::class, 'mostrarTmpCompras'])->name('compras.tmp');

 //RUTAS PARA CLIENTES
Route::get('/admin/clientes/reporte', [App\Http\Controllers\ClienteController::class, 'generarReporte'])
     ->name('admin.clientes.reporte');
 Route::get('/admin/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('admin.clientes.index')->middleware('auth');
 Route::get('/admin/clientes/create', [App\Http\Controllers\ClienteController::class, 'create'])->name('admin.clientes.create')->middleware('auth');
 Route::post('/admin/clientes/create', [App\Http\Controllers\ClienteController::class, 'store'])->name('admin.clientes.store')->middleware('auth');
 Route::get('/admin/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'show'])->name('admin.clientes.show')->middleware('auth');
 Route::get('/admin/clientes/{id}/edit', [App\Http\Controllers\ClienteController::class, 'edit'])->name('admin.clientes.edit')->middleware('auth');
 Route::put('/admin/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'update'])->name('admin.clientes.update')->middleware('auth');
 Route::delete('/admin/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('admin.clientes.destroy')->middleware('auth');
       
         //RUTAS PARA VENTAS

         Route::get('/admin/ventas', [App\Http\Controllers\VentaController::class, 'index'])->name('admin.ventas.index')->middleware('auth');
         Route::get('/admin/ventas/create', [App\Http\Controllers\VentaController::class, 'create'])->name('admin.ventas.create')->middleware('auth');
         Route::post('/admin/ventas/create', [App\Http\Controllers\VentaController::class, 'store'])->name('admin.ventas.store')->middleware('auth');
         Route::get('/admin/ventas/{id}', [App\Http\Controllers\VentaController::class, 'show'])->name('admin.ventas.show')->middleware('auth');

Route::get('/admin/ventas/pdf/{id}', [App\Http\Controllers\VentaController::class, 'pdf'])->name('admin.ventas.pdf')->middleware('auth');

         Route::get('/admin/ventas/{id}/edit', [App\Http\Controllers\VentaController::class, 'edit'])->name('admin.ventas.edit')->middleware('auth');
         Route::put('/admin/ventas/{id}', [App\Http\Controllers\VentaController::class, 'update'])->name('admin.ventas.update')->middleware('auth');
         Route::delete('/admin/ventas/{id}', [App\Http\Controllers\VentaController::class, 'destroy'])->name('admin.ventas.destroy')->middleware('auth');  
         //ruta para crear al cliente
         Route::post('/admin/ventas/cliente/create', [App\Http\Controllers\VentaController::class, 'cliente_store'])->name('admin.ventas.cliente.store')->middleware('auth');


          Route::get('/admin/ventas/reporte/{tipo}', [App\Http\Controllers\VentaController::class, 'reporte'])
     ->where('tipo', 'pdf|excel|csv')
     ->name('admin.ventas.reporte');
     
         //tmp ventas
      Route::post('/admin/ventas/create/tmp', [App\Http\Controllers\TmpVentaController::class, 'tmp_ventas'])->name('admin.ventas.tmp_ventas')->middleware('auth');
      Route::delete('/admin/ventas/create/tmp/{id}', [App\Http\Controllers\TmpVentaController::class, 'destroy'])->name('admin.ventas.tmp_ventas.destroy')->middleware('auth');
      

      //ruta para detalles de la ventas
      Route::post('/admin/ventas/detalle/create', [App\Http\Controllers\DetalleVentaController::class, 'store'])->name('admin.detalle.ventas.store')->middleware('auth');
      Route::delete('/admin/ventas/detalle/{id}', [App\Http\Controllers\DetalleVentaController::class, 'destroy'])->name('admin.detalle.ventas.destroy')->middleware('auth'); 
      
    //RUTAS PARA CAJA

    Route::get('/admin/cajas', [App\Http\Controllers\CajaController::class, 'index'])->name('admin.cajas.index')->middleware('auth');
    Route::get('/admin/cajas/create', [App\Http\Controllers\CajaController::class, 'create'])->name('admin.cajas.create')->middleware('auth');
    Route::post('/admin/cajas/create', [App\Http\Controllers\CajaController::class, 'store'])->name('admin.cajas.store')->middleware('auth');
    Route::get('/admin/cajas/{id}', [App\Http\Controllers\CajaController::class, 'show'])->name('admin.cajas.show')->middleware('auth');
    Route::get('/admin/cajas/{id}/edit', [App\Http\Controllers\CajaController::class, 'edit'])->name('admin.cajas.edit')->middleware('auth');
    Route::put('/admin/cajas/{id}', [App\Http\Controllers\CajaController::class, 'update'])->name('admin.cajas.update')->middleware('auth');
    Route::delete('/admin/cajas/{id}', [App\Http\Controllers\CajaController::class, 'destroy'])->name('admin.cajas.destroy')->middleware('auth');
  
 Route::get('/admin/cajas/reporte/{tipo}', [App\Http\Controllers\CajaController::class, 'reportecaja'])
     ->where('tipo', 'pdf|excel|csv')
     ->name('admin.cajas.reporte');

     
     Route::get('/admin/cajas/pdf/{id}', [App\Http\Controllers\CajaController::class, 'pdf'])
     ->name('admin.cajas.pdf')
     ->middleware('auth');


     // ruta de ingreso
     Route::get('/admin/cajas/{id}/ingreso-egreso', [App\Http\Controllers\CajaController::class, 'ingresoegreso'])->name('admin.cajas.ingresoegreso')->middleware('auth');
     Route::post('/admin/cajas/create_ingresos_egresos', [App\Http\Controllers\CajaController::class, 'store_ingresos_egresos'])->name('admin.cajas.storeingresosegresos')->middleware('auth');
     Route::get('/admin/cajas/{id}/cierre', [App\Http\Controllers\CajaController::class, 'cierre'])->name('admin.cajas.cierre')->middleware('auth');
     Route::post('/admin/cajas/create_cierre', [App\Http\Controllers\CajaController::class, 'store_cierre'])->name('admin.cajas.storecierre')->middleware('auth');

     // Mostrar la reporte de inresos 
Route::get('admin/reporte/ingresos', [App\Http\Controllers\reporteController::class, 'reporteIngresosView'])->name('admin.reporte.ingresos');
Route::get('admin/reporte/ingresos-por-fecha', [App\Http\Controllers\reporteController::class, 'ingresosPorFecha'])->name('admin.reporte.ingresos_por_fecha');
Route::get('admin/reporte/ingresos_por_fecha/pdf', [App\Http\Controllers\reporteController::class, 'ingresosPorFechaPDF'])->name('admin.reporte.ingresos_por_fecha_pdf');


     // Mostrar la reporte de inresos 
     Route::get('admin/reporte/egresos', [App\Http\Controllers\reporteController::class, 'reporteEgresosView'])->name('admin.reporte.egresos');
     Route::get('admin/reporte/egresos-por-fecha', [App\Http\Controllers\reporteController::class, 'EgresosPorFecha'])->name('admin.reporte.egresos_por_fecha');
     Route::get('admin/reporte/egresos_por_fecha/pdf', [App\Http\Controllers\reporteController::class, 'EgresosPorFechaPDF'])->name('admin.reporte.egresos_por_fecha_pdf');
       

//rutas para permisos

Route::get('/admin/permisos', [App\Http\Controllers\PermisoController::class, 'index'])->name('admin.permisos.index')->middleware('auth');
Route::get('/admin/permisos/create', [App\Http\Controllers\PermisoController::class, 'create'])->name('admin.permisos.create');
Route::post('/admin/permisos/create', [App\Http\Controllers\PermisoController::class, 'store'])->name('admin.permisos.store');
Route::get('/admin/permisos/{id}', [App\Http\Controllers\PermisoController::class, 'show'])->name('admin.permisos.show')->middleware('auth');
Route::get('/admin/permisos/{id}/edit', [App\Http\Controllers\PermisoController::class, 'edit'])->name('admin.permisos.edit')->middleware('auth');
Route::put('/admin/permisos/{id}', [App\Http\Controllers\PermisoController::class, 'update'])->name('admin.permisos.update')->middleware('auth');
Route::delete('/admin/permisos/{id}', [App\Http\Controllers\PermisoController::class, 'destroy'])->name('admin.permisos.destroy')->middleware('auth');
Route::get('/admin/permisos/reporte', [App\Http\Controllers\PermisoController::class, 'reporte'])->name('admin.permisos.reporte');

Route::get('/admin/productos/buscar', [App\Http\Controllers\ProductoController::class, 'buscar'])->name('admin.productos.buscar');
Route::get('/admin/productos/get/{id}', [App\Http\Controllers\ProductoController::class, 'get'])->name('admin.productos.get');
Route::get('/admin/laboratorios/buscar', [App\Http\Controllers\LaboratorioController::class, 'buscar'])->name('admin.laboratorios.buscar');


Route::post('/compras/agregar-tmp', [App\Http\Controllers\CompraController::class, 'agregarTmp'])->name('admin.compras.agregar-tmp');
Route::post('/compras/eliminar-tmp', [App\Http\Controllers\CompraController::class, 'eliminarTmp'])->name('admin.compras.eliminar-tmp');
Route::post('/compras/actualizar-tmp', [App\Http\Controllers\CompraController::class, 'actualizarTmp'])->name('admin.compras.actualizar-tmp');





// Catálogo público
Route::get('/admin/catalogo', [App\Http\Controllers\CatalogController::class, 'index'])->name('admin.catalogo.index');
Route::get('/admin/catalogo/{producto}', [App\Http\Controllers\CatalogController::class, 'show'])->name('admin.catalogo.show');


Route::get('/admin/catalogo', [App\Http\Controllers\CatalogController::class, 'index'])->name('admin.catalogo.index');
Route::get('/admin/catalogo/{id}', [App\Http\Controllers\CatalogController::class, 'show'])->name('admin.catalogo.show');



Route::get('/admin/catalogo/categoria/{categoria}', [App\Http\Controllers\CatalogController::class, 'ver'])->name('admin.catalogo.categoria');





     // Ruta para el formulario de búsqueda (GET)
Route::get('/admin/buscar-productos', [App\Http\Controllers\CatalogController::class, 'buscar'])
->name('admin.catalogo.buscar');

// Ruta para el autocompletado (AJAX)
Route::get('/admin/buscar-autocomplete', [App\Http\Controllers\CatalogController::class, 'search'])
->name('admin.catalogo.search');


// lotes rutas
Route::get('/admin/lotes/reporte', [App\Http\Controllers\LoteController::class, 'generarReporte'])
     ->name('admin.lotes.reporte');
    Route::get('/admin/lotes', [App\Http\Controllers\LoteController::class, 'index'])->name('admin.lotes.index')->middleware('auth');
    Route::get('/admin/lotes/create', [App\Http\Controllers\LoteController::class, 'create'])->name('admin.lotes.create')->middleware('auth');
    Route::post('/admin/lotes/create', [App\Http\Controllers\LoteController::class, 'store'])->name('admin.lotes.store')->middleware('auth');
    Route::get('/admin/lotes/{id}', [App\Http\Controllers\LoteController::class, 'show'])->name('admin.lotes.show')->middleware('auth');
    Route::get('/admin/lotes/{id}/edit', [App\Http\Controllers\LoteController::class, 'edit'])->name('admin.lotes.edit')->middleware('auth');
    Route::put('/admin/lotes/{id}', [App\Http\Controllers\LoteController::class, 'update'])->name('admin.lotes.update')->middleware('auth');
    Route::delete('/admin/lotes/{id}', [App\Http\Controllers\LoteController::class, 'destroy'])->name('admin.lotes.destroy')->middleware('auth');


    //cchat
    Route::post('/chat-ia', [App\Http\Controllers\ChatIAController::class, 'preguntar']);


    // inventario
    Route::get('/admin/inventario', [App\Http\Controllers\InventarioController::class, 'index'])->name('admin.inventario.index');

   
     Route::get('/admin/inventario/bajo-stock', [App\Http\Controllers\InventarioController::class, 'bajoStock'])->name('admin.inventario.bajo_stock');


Route::get('/admin/inventario/productos_porvencer', [App\Http\Controllers\InventarioController::class, 'productosPorVencer' ])->name('admin.inventario.productos_porvencer');

     Route::get('/admin/compras/mensual', [App\Http\Controllers\InventarioController::class, 'comprasMensuales'])->name('admin.compras.mensual');
Route::get('/admin/inventario/reporte_compras', [App\Http\Controllers\InventarioController::class, 'imprimirCompras'])->name('admin.inventario.reporte_compras');

Route::get('/admin/inventario/reporte_ventas', [App\Http\Controllers\InventarioController::class, 'imprimirVentas'])->name('admin.inventario.reporte_ventas');

Route::get('/admin/inventario/reportegeneral', [App\Http\Controllers\InventarioController::class, 'reporteGeneral'])->name('admin.inventario.reportegeneral');