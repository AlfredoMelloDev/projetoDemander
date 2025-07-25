<?php

namespace App\Http\Controllers;

use App\Models\Situacao;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SituacaoController extends Controller
{
    public function importar()
    {
        $response = Http::get("https://dadosabertos.camara.leg.br/api/v2/referencias/situacoesDeputado");

        if ($response->successful()) {
            $dados = $response->json()['dados'];

            foreach ($dados as $situacao) {
                Situacao::updateOrCreate(
                    ['descricao' => $situacao['descricao']],
                    ['sigla' => $situacao['sigla'] ?? null]
                );
            }

            return response()->json(['success' => true, 'message' => 'Situações importadas com sucesso']);
        }

        return response()->json(['success' => false, 'message' => 'Erro ao importar dados da API'], 500);
    }
}
