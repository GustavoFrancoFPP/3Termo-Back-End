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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "SENAI - Sala 101"
            $table->string('code')->unique(); // Ex: "SALA-101"
            $table->string('block')->nullable(); // Ex: "Bloco A"
            $table->integer('capacity')->default(30);
            $table->string('location')->nullable(); // Ex: "Andar 1"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
