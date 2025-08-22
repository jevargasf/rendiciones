<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\SubvencionesController;
use App\Http\Controllers\RendicionesController;
use App\Http\Controllers\Rendiciones2Controller;
use App\Http\Controllers\RendicionesDosController;

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

    Route::get('/', [SubvencionesController::class, 'index'])->name('subvenciones');

    Route::post('crear', [SubvencionesController::class, 'crear'])->name('subvenciones.crear');


});

Route::prefix('rendiciones')->group(function () {

    Route::get('/', [RendicionesController::class, 'index'])->name('rendiciones');

    
});

Route::prefix('rendicionesDos')->group(function () {

    Route::get('/', [RendicionesDosController::class, 'index'])->name('rendicionesDos');

    Route::post('detalleRendicion/{id}',[RendicionesDosController::class, 'detalleRendicion'])->name('rendicionesDos.detalleRendicion'); 

});

//});  