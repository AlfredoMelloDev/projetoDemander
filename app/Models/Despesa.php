<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa (mass assignment)
    protected $fillable = [
        'deputado_id',   // ID do deputado relacionado (chave estrangeira)
        'tipo_despesa',  // Tipo da despesa (ex: alimentação, transporte)
        'fornecedor',    // Nome do fornecedor ou empresa que recebeu a despesa
        'valor_liquido',         // Valor da despesa
        'data',          // Data da despesa
    ];

    

    /**
     * Relacionamento: Uma despesa pertence a um deputado.
     * Define que o model Despesa pertence ao model Deputado,
     * usando a chave estrangeira 'deputado_id' nesta tabela e a chave primária 'id' na tabela deputados.
     */
    public function deputado()
    {
        return $this->belongsTo(Deputado::class, 'deputado_id', 'id');
    }

    
}
