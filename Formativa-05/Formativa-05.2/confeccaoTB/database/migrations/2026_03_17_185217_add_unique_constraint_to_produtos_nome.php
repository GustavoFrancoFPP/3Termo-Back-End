<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // Primeiro remover possíveis duplicatas que ainda possam existir
            $duplicados = DB::table('produtos')
                ->select('nome')
                ->groupBy('nome')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('nome');

            foreach ($duplicados as $nome) {
                // Manter apenas o produto mais recente, deletar os outros
                $produtos = DB::table('produtos')
                    ->where('nome', $nome)
                    ->orderBy('created_at', 'desc')
                    ->skip(1) // Pular o primeiro (mais recente)
                    ->pluck('id');

                DB::table('produtos')->whereIn('id', $produtos)->delete();
            }

            // Adicionar constraint única
            $table->unique('nome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropUnique(['nome']);
        });
    }
};
