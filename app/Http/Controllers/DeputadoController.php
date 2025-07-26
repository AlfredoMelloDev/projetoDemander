<?php

namespace App\Http\Controllers;

use App\Jobs\SincronizarDeputadosJob;
use App\Models\Deputado;
use Illuminate\Http\Request;

class DeputadoController extends Controller
{
    /**
     * Página inicial para listar deputados com filtro por nome.
     */
    public function index(Request $request)
    {
        $query = Deputado::with('despesas');

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        $deputados = $query->orderBy('id')->paginate(10);

        return view('deputados.index', compact('deputados'));
    }


    /**
     * Método para iniciar a sincronização dos deputados (dispara o job).
     */
    public function sincronizar()
    {
        SincronizarDeputadosJob::dispatch();

        return redirect()->route('deputados.index')
            ->with('status', 'Sincronização iniciada! Aguarde o processamento.');
    }

    public function show($id)
    {
        $deputado = Deputado::with('despesas')->findOrFail($id);
        return view('deputados.show', compact('deputado'));
    }
}

