<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\TiendaController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\SubcategoriaController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProductoImagenController;
use App\Http\Controllers\Admin\ProductoVarianteController;
use App\Http\Controllers\Admin\DashboardController;

// ===== Tienda (público) =====
Route::get('/', [TiendaController::class, 'home'])->name('tienda.home');
Route::get('/categoria/{slug}', [TiendaController::class, 'categoria'])->name('tienda.categoria');
Route::get('/producto/{slug}', [TiendaController::class, 'producto'])->name('tienda.producto');

// ===== Tienda mayorista (público, mismo controlador) =====
Route::prefix('mayorista')->name('mayorista.')->group(function () {
    Route::get('/', [TiendaController::class, 'home'])->name('home');
    Route::get('/categoria/{slug}', [TiendaController::class, 'categoria'])->name('categoria');
    Route::get('/producto/{slug}', [TiendaController::class, 'producto'])->name('producto');
});


// ===== Login del admin (público, sin middleware) =====
Route::get('/admin/login', [AuthController::class, 'mostrarLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::post('/canal', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'canal' => 'required|in:normal,mayorista',
            'redirigir_a' => 'nullable|string',
        ]);
        session(['admin_canal' => $request->canal]);

        if ($request->filled('redirigir_a')) {
            return redirect()->to($request->redirigir_a);
        }

        return redirect()->back();
    })->name('canal.set');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/categorias/reordenar', [CategoriaController::class, 'reordenar'])->name('categorias.reordenar');
    Route::resource('categorias', CategoriaController::class)->except(['create', 'edit', 'show']);

    Route::post('/subcategorias/reordenar', [SubcategoriaController::class, 'reordenar'])->name('subcategorias.reordenar');
    Route::resource('subcategorias', SubcategoriaController::class)->except(['create', 'edit', 'show']);


    Route::resource('productos', ProductoController::class)->except(['create', 'edit']);

    Route::post('/productos/{producto}/imagenes', [ProductoImagenController::class, 'store'])->name('productos.imagenes.store');
    Route::delete('/productos/{producto}/imagenes/{imagen}', [ProductoImagenController::class, 'destroy'])->name('productos.imagenes.destroy');

    Route::post('/productos/{producto}/variantes', [ProductoVarianteController::class, 'store'])->name('productos.variantes.store');
    Route::put('/productos/{producto}/variantes/{variante}', [ProductoVarianteController::class, 'update'])->name('productos.variantes.update');
    Route::delete('/productos/{producto}/variantes/{variante}', [ProductoVarianteController::class, 'destroy'])->name('productos.variantes.destroy');
    Route::put('productos/{producto}/imagenes/{imagen}', [ProductoImagenController::class, 'update'])
        ->name('productos.imagenes.update');
});
