<?php

namespace App\Http\Controllers;

use App\Models\Orgao;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class OrgaoController extends Controller
{
    public function importar($deputadoId)
    {
        $response = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$deputadoId}/orgaos");

        if ($response->successful()) {
            $dados = $response->json()['dados'];

            foreach ($dados as $orgao) {
                Orgao::updateOrCreate(
                    [
                        'deputado_id' => $deputadoId,
                        'nome' => $orgao['nome'],
                    ],
                    [
                        'sigla' => $orgao['sigla'] ?? null,
                        'apelido' => $orgao['apelido'] ?? null,
                    ]
                );
            }

            return response()->json(['success' => true, 'message' => 'Órgãos importados com sucesso']);
        }

        return response()->json(['success' => false, 'message' => 'Erro ao importar dados da API'], 500);
    }
}
