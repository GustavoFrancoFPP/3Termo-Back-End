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
        Schema::create('new_mons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('pokemon_id');
            $table->string('type');
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->json('abilities');
            $table->json('stats');
            $table->string('sprite_official')->nullable();
            $table->string('sprite_front')->nullable();
            $table->string('sprite_back')->nullable();
            $table->string('sprite_front_shiny')->nullable();
            $table->string('sprite_back_shiny')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_mons');
    }
};
