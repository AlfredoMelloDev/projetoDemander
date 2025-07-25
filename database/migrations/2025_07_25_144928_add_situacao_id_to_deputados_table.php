<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('deputados', function (Blueprint $table) {
            $table->foreignId('situacao_id')->nullable()->constrained('situacoes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('deputados', function (Blueprint $table) {
            $table->dropForeign(['situacao_id']);
            $table->dropColumn('situacao_id');
        });
    }
};
