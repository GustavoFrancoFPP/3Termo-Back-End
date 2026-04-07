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
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->nullable()->constrained('produtos')->cascadeOnDelete();
            $table->foreignId('insumo_id')->nullable()->constrained('insumos')->cascadeOnDelete();
            $table->decimal('quantidade', 10, 2)->default(0);
            $table->enum('tipo', ['entrada', 'saída'])->default('entrada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};
