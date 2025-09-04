<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\SubvencionController;
use App\Http\Controllers\RendicionController;

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

    Route::post('eliminar', [SubvencionController::class, 'eliminar'])->name('subvenciones.eliminar');

});


Route::prefix('rendiciones')->group(function () {

    Route::get('/', [RendicionController::class, 'index'])->name('rendiciones');

    Route::post('/detalleRendicion',[RendicionController::class, 'detalleRendicion'])->name('rendiciones.detalleRendicion'); 

});

//});  