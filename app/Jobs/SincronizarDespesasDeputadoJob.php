<?php

namespace App\Jobs;

use App\Models\Despesa;
use App\Models\Deputado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;  // Para colocar o job na fila
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SincronizarDespesasDeputadoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $idDeputadoApi;  // ID do deputado na API

    /**
     * Cria uma nova instância do job.
     *
     * @param int $idDeputadoApi ID do deputado na API da Câmara
     */
    public function __construct(int $idDeputadoApi)
    {
        $this->idDeputadoApi = $idDeputadoApi;
    }

    /**
     * Executa o job de sincronização das despesas.
     */
    public function handle()
    {
        // Busca o deputado local pelo ID da API
        $deputado = Deputado::where('deputado_id', $this->idDeputadoApi)->first();

        if (!$deputado) {
            // Se deputado não existir localmente, para a execução
            return;
        }

        // Faz a requisição para API de despesas do deputado
        $response = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$this->idDeputadoApi}/despesas");

        if ($response->successful()) {
            $despesas = $response->json('dados');

            foreach ($despesas as $d) {
                // Atualiza ou cria despesa para evitar duplicatas
                Despesa::updateOrCreate(
                    [
                        'deputado_id' => $deputado->id,
                        'fornecedor' => $d['nomeFornecedor'] ?? '',
                        'data' => $d['dataDocumento'] ?? null,
                        'valor' => $d['valorLiquido'] ?? 0,
                    ],
                    [
                        'tipo_despesa' => $d['tipoDespesa'] ?? '',
                    ]
                );
            }
        }
    }
}
