<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;

class CleanDuplicateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'produtos:clean-duplicates {--dry-run : Mostrar apenas o que seria feito sem executar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove produtos duplicados mantendo apenas o mais recente de cada nome';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando produtos duplicados...');

        // Encontrar nomes duplicados
        $duplicados = DB::table('produtos')
            ->select('nome')
            ->groupBy('nome')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('nome');

        if ($duplicados->isEmpty()) {
            $this->info('✅ Nenhum produto duplicado encontrado!');
            return;
        }

        $this->warn("📋 Encontrados {$duplicados->count()} nomes de produtos duplicados:");
        foreach ($duplicados as $nome) {
            $this->line("  - {$nome}");
        }

        $totalRemovidos = 0;

        foreach ($duplicados as $nome) {
            // Buscar todos os produtos com este nome, ordenados por data de criação (mais recente primeiro)
            $produtos = Produto::where('nome', $nome)
                ->orderBy('created_at', 'desc')
                ->get();

            // Manter o primeiro (mais recente) e remover os outros
            $produtosParaRemover = $produtos->skip(1);

            if ($this->option('dry-run')) {
                $this->info("🔸 [DRY RUN] Manteria: {$produtos->first()->nome} (ID: {$produtos->first()->id})");
                foreach ($produtosParaRemover as $produto) {
                    $this->warn("🔸 [DRY RUN] Removeria: {$produto->nome} (ID: {$produto->id})");
                }
            } else {
                foreach ($produtosParaRemover as $produto) {
                    $produto->delete();
                    $this->warn("🗑️  Removido: {$produto->nome} (ID: {$produto->id})");
                    $totalRemovidos++;
                }
                $this->info("✅ Mantido: {$produtos->first()->nome} (ID: {$produtos->first()->id})");
            }
        }

        if ($this->option('dry-run')) {
            $this->info("🔍 Dry run concluído. Use sem --dry-run para executar realmente.");
        } else {
            $this->info("🎉 Limpeza concluída! {$totalRemovidos} produtos duplicados removidos.");
        }

        // Verificar resultado final
        $totalProdutos = Produto::count();
        $this->info("📊 Total de produtos restantes: {$totalProdutos}");
    }
}
