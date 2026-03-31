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
        if (! Schema::hasTable('estoques')) {
            return;
        }

        Schema::table('estoques', function (Blueprint $table) {
            if (! Schema::hasColumn('estoques', 'produto_id')) {
                $table->foreignId('produto_id')->nullable()->constrained('produtos')->cascadeOnDelete();
            }

            if (! Schema::hasColumn('estoques', 'quantidade')) {
                $table->integer('quantidade')->default(0);
            }

            if (! Schema::hasColumn('estoques', 'tipo_movimento')) {
                $table->string('tipo_movimento')->default('entrada');
            }

            if (! Schema::hasColumn('estoques', 'observacao')) {
                $table->text('observacao')->nullable();
            }

            if (! Schema::hasColumn('estoques', 'tipo')) {
                $table->string('tipo')->default('entrada');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('estoques')) {
            return;
        }

        Schema::table('estoques', function (Blueprint $table) {
            foreach (['observacao', 'tipo', 'tipo_movimento', 'quantidade'] as $column) {
                if (Schema::hasColumn('estoques', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('estoques', 'produto_id')) {
                $table->dropConstrainedForeignId('produto_id');
            }
        });
    }
};
