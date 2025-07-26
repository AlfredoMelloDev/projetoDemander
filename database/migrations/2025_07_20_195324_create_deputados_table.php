<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deputados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deputado_id')->unique(); // Corrigido aqui
            $table->string('nome');
            $table->string('sigla_partido');
            $table->string('sigla_uf');
            $table->string('sigla_sexo')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('uri')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('municipio_nascimento')->nullable();
            $table->string('uf_nascimento')->nullable();
            $table->json('rede_social')->nullable();
            $table->string('url_website')->nullable();
            $table->string('condicao_eleitoral')->nullable();
            $table->string('situacao')->nullable();
            $table->string('descricao_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deputados');
    }
};
