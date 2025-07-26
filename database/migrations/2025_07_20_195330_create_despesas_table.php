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
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();

            // FK para deputados.deputado_id (precisa ser unsignedBigInteger, igual na tabela deputados)
            $table->unsignedBigInteger('deputado_id');

            $table->string('tipo_despesa');
            $table->decimal('valor', 10, 2);
            $table->string('fornecedor');
            $table->date('data_despesa');
            $table->timestamps();

            // Chave estrangeira corrigida
            $table->foreign('deputado_id')
                ->references('deputado_id')
                ->on('deputados')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
