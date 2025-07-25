<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{
    protected $fillable = [
        'deputado_id',
        'nome',
        'sigla',
        'apelido'
    ];

    public function deputado()
    {
        return $this->belongsTo(Deputado::class);
    }
}
