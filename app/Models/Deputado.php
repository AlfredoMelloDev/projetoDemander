<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    use HasFactory;

    protected $fillable = [
        'despesas_id',
        'nome',
        'sigla_partido',
        'sigla_uf',
        'email',
        'telefone',
        'foto',
        'sigla_sexo',
    ];

    /**
     * Relacionamento: Um deputado possui várias despesas.
     */
    public function despesas()
    {
        return $this->hasMany(\App\Models\Despesa::class, 'deputado_id', 'deputado_id');
    }
}