<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeputadoController;
use App\Jobs\SincronizarDeputadosJob;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DeputadoController::class, 'index'])->name('deputados.index');
Route::get('/sincronizar', [DeputadoController::class, 'sincronizar'])->name('deputados.sincronizar');



Route::get('/sincronizar-deputados', function () {
    SincronizarDeputadosJob::dispatch(); // Dispara a job para a fila
    return 'Sincronização iniciada!';
});


Route::get('/deputados/{id}', [DeputadoController::class, 'show'])->name('deputados.show');
