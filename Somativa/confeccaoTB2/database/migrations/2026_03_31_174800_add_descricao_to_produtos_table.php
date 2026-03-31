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
        if (! Schema::hasTable('produtos')) {
            return;
        }

        Schema::table('produtos', function (Blueprint $table) {
            if (! Schema::hasColumn('produtos', 'descricao')) {
                $table->text('descricao')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('produtos') || ! Schema::hasColumn('produtos', 'descricao')) {
            return;
        }

        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('descricao');
        });
    }
};
