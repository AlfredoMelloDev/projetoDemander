<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Deputado;
use App\Models\Situacao;
use UConverter;

class SincronizarDeputadosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $filtros;

    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function handle()
    {
        $url = 'https://dadosabertos.camara.leg.br/api/v2/deputados';

        $response = Http::withOptions(['verify' => false])->get($url, $this->filtros);

        if ($response->failed()) {
            Log::error('Erro ao buscar deputados na API', ['url' => $url, 'filtros' => $this->filtros]);
            return;
        }

        $deputados = $response->json()['dados'];

        foreach ($deputados as $item) {
            $detalhes = Http::withOptions(['verify' => false])->get($item['uri']);

            if ($detalhes->successful()) {
                $dados = $detalhes->json()['dados'];

                echo json_encode($dados);
                $detected_encoding = mb_detect_encoding($dados['ultimoStatus']['situacao']);
                echo "Detected encoding (default order): " . $detected_encoding . "\n";






                // 🔧 NOVO: buscar a situação correspondente no banco
                $situacao = Situacao::where('descricao', $dados['ultimoStatus']['situacao'])->first();

                // 🔧 MODIFICADO: incluímos situacao_id no updateOrCreate
                Deputado::updateOrCreate(
                    ['deputado_id' => $dados['id']],
                    [
                        'nome'         => $dados['ultimoStatus']['nome'] ?? null,
                        'partido'      => $dados['ultimoStatus']['siglaPartido'] ?? null,
                        'estado'       => $dados['ultimoStatus']['siglaUf'] ?? null,
                        'email'        => $dados['ultimoStatus']['gabinete']['email'] ?? null,
                        'telefone'     => $dados['ultimoStatus']['gabinete']['telefone'] ?? null,
                        'foto'         => $dados['ultimoStatus']['urlFoto'] ?? null,
                        'sigla_sexo'   => $dados['sexo']['sexo'] ?? null,
                        'data_despesa' => $dados['data_despesa'] ?? null,

                        // ✅ Salva o relacionamento
                        'situacao_id'  => $situacao?->id,
                    ]
                );
            } else {
                Log::warning("Erro ao buscar detalhes do deputado ID {$item['id']}");
            }
        }



        
        Log::info('Deputados sincronizados com sucesso.', ['filtros' => $this->filtros]);
    }
}
