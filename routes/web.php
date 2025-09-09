<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\SubvencionController;
use App\Http\Controllers\RendicionController;
use App\Http\Controllers\PersonaController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'index']);

Route::post('/perfiles', [AuthController::class, 'seleccionarPerfil'])->name('perfiles');
Route::get('/perfiles', [AuthController::class, 'seleccionarPerfil']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Route::middleware(['km'])->group(function () {

Route::prefix('estadisticas')->group(function () {

    Route::get('/', [InicioController::class, 'index'])->name('estadisticas');

    Route::get('/{year}', [InicioController::class, 'getStatistics'])->name('estadisticas.statistics');
});

Route::prefix('subvenciones')->group(function () {

    Route::get('/', [SubvencionController::class, 'index'])->name('subvenciones');

    Route::post('crear', [SubvencionController::class, 'crear'])->name('subvenciones.crear');

    Route::post('obtener', [SubvencionController::class, 'obtener'])->name('subvenciones.obtener');

    Route::post('actualizar', [SubvencionController::class, 'actualizar'])->name('subvenciones.actualizar');

    Route::post('eliminar', [SubvencionController::class, 'eliminar'])->name('subvenciones.eliminar');

    Route::post('obtener-datos-rendir', [SubvencionController::class, 'obtenerDatosRendir'])->name('subvenciones.obtener-datos-rendir');
    Route::post('guardar-rendicion', [SubvencionController::class, 'guardarRendicion'])->name('subvenciones.guardar-rendicion');

});


Route::prefix('rendiciones')->group(function () {

    Route::get('/', [RendicionController::class, 'index'])->name('rendiciones');

    Route::get('/detalleRendicion',[RendicionController::class, 'detalleRendicion'])->name('rendiciones.detalleRendicion'); 

    Route::post('/eliminar-temporalmente', [RendicionController::class, 'eliminarTemporalmente'])->name('rendiciones.eliminar-temporalmente');

    Route::post('/actualizar-estado', [RendicionController::class, 'actualizarEstado'])->name('rendiciones.actualizar-estado');

});

Route::prefix('personas')->group(function () {

    Route::post('obtener', [PersonaController::class, 'obtener'])->name('personas.obtener');
    Route::post('buscar', [PersonaController::class, 'buscar'])->name('personas.buscar');
    Route::post('guardar', [PersonaController::class, 'guardar'])->name('personas.guardar');

});

//});  