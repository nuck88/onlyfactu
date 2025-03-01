<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\PreciosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\SupermercadosController;
use App\Models\Supermercado;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/comparador', function(){
    return view('comparador');
})->middleware(['auth'])->name('comparador');

Route::get('/conceptos', function(){
    return view('conceptos');
})->middleware(['auth'])->name('conceptos');

Route::get('/ingresos', function(){
    return view('ingresos');
})->middleware(['auth'])->name('ingresos');

Route::get('/gastos', function(){
    return view('gastos');
})->middleware(['auth'])->name('gastos');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/categorias', [CategoriaController::class, 'index'])->middleware(['auth'])->name('categorias');
Route::delete('/categorias/{id}', [CategoriaController::class, 'delete'])->name('categorias.delete');
Route::post('/categorias', [CategoriaController::class, 'nuevo'])->name('categorias.nuevo');

Route::get('/conceptos', [ConceptoController::class, 'index'])->middleware(['auth'])->name('conceptos');
Route::delete('/conceptos/{id}', [ConceptoController::class, 'delete'])->name('concepto.delete');
Route::post('/conceptos', [ConceptoController::class, 'nuevo'])->name('concepto.nuevo');

Route::get('/dashboard', [GastosController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/ingresos', [IngresoController::class, 'index'])->middleware(['auth'])->name('ingresos');
Route::delete('/ingresos/{id}', [IngresoController::class, 'delete'])->name('ingresos.delete');
Route::post('/ingresos', [IngresoController::class, 'nuevo'])->name('ingresos.nuevo');

Route::get('/gastos', [GastosController::class, 'gastos'])->middleware(['auth'])->name('gastos');
Route::delete('/gastos/{id}', [GastosController::class, 'delete'])->middleware(['auth'])->name('gasto.delete');
Route::post('/gastos', [GastosController::class, 'nuevo'])->middleware(['auth'])->name('gasto.nuevo');

Route::get('/conceptos/por-categoria/{categoria_id}', [ConceptoController::class, 'obtenerPorCategoria'])->name('conceptos.por-categoria');

Route::get('/comparador', [SupermercadosController::class, 'index'])->middleware(['auth'])->name('comparador');
Route::post('/comparador/supermercados', [SupermercadosController::class, 'nuevo'])->middleware(['auth'])->name('supermercado.nuevo');
Route::post('/comparador/productos', [ProductosController::class, 'index'])->middleware(['auth'])->name('producto.nuevo');
Route::post('/comparador/precio', [PreciosController::class, 'nuevo'])->middleware(['auth'])->name('comparacion.nuevo');





require __DIR__.'/auth.php';
