<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\compraController;
use App\Http\Controllers\GraficoController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\presentacioneController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\proveedorController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\ventaController;
use Illuminate\Support\Facades\Route;

Route::get('/',[homeController::class,'index'])->name('panel');
Route::get('/ventas/pdf',[ventaController::class,'ventaPdf'])->name('venta.pdf');
Route::get('/ventas/reporte',[ventaController::class,'reporteVentas'])->name('venta.reporte');

Route::get('/clientes/pdf',[clienteController::class,'clientePdf'])->name('cliente.pdf');


Route::get('pdf/generate-pdf', [PdfController::class, 'pdf'])->name('pdf.generate-pdf');


Route::resources([
    'categorias' => categoriaController::class,
    'presentaciones' => presentacioneController::class,
    'marcas' => marcaController::class,
    'productos' => ProductoController::class,
    'clientes' => clienteController::class,
    'proveedores' => proveedorController::class,
    'compras' => compraController::class,
    'ventas' => ventaController::class,
    'users' => userController::class,
    'roles' => roleController::class,
    'profile' => profileController::class,
    'prueba' => PruebaController::class,
    'pdf' => PdfController::class,
    'grafico' => GraficoController::class

]);

Route::get('/login',[loginController::class,'index'])->name('login');
Route::post('/login',[loginController::class,'login']);
Route::get('/logout',[logoutController::class,'logout'])->name('logout');

Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});
