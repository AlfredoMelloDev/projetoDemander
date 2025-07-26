<?php

use App\Http\Controllers\DeputadoController;
use App\Http\Controllers\OrgaoController;
use App\Http\Controllers\SituacaoController;
use App\Jobs\SincronizarDeputadosJob;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DeputadoController::class, 'index'])->name('deputados.index');
Route::get('/sincronizar', [DeputadoController::class, 'sincronizar'])->name('deputados.sincronizar');



Route::get('/sincronizar-deputados', function () {
    SincronizarDeputadosJob::dispatch(); // Dispara a job para a fila
    return 'Sincronização iniciada!';
});


Route::get('/deputados/{id}', [DeputadoController::class, 'show'])->name('deputados.show');


Route::get('/deputados/{id}/importar-orgaos', [OrgaoController::class, 'importar']);
Route::get('/importar-situacoes', [SituacaoController::class, 'importar']);
