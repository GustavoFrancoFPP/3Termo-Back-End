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
        if (! Schema::hasTable('fornecedors')) {
            return;
        }

        Schema::table('fornecedors', function (Blueprint $table) {
            if (Schema::hasColumn('fornecedors', 'Nome')) {
                $table->renameColumn('Nome', 'nome');
            }

            if (Schema::hasColumn('fornecedors', 'E-mail')) {
                $table->renameColumn('E-mail', 'email');
            }

            if (Schema::hasColumn('fornecedors', 'Telefone')) {
                $table->renameColumn('Telefone', 'telefone');
            }

            if (Schema::hasColumn('fornecedors', 'CNPJ')) {
                $table->renameColumn('CNPJ', 'cnpj');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('fornecedors')) {
            return;
        }

        Schema::table('fornecedors', function (Blueprint $table) {
            if (Schema::hasColumn('fornecedors', 'nome')) {
                $table->renameColumn('nome', 'Nome');
            }

            if (Schema::hasColumn('fornecedors', 'email')) {
                $table->renameColumn('email', 'E-mail');
            }

            if (Schema::hasColumn('fornecedors', 'telefone')) {
                $table->renameColumn('telefone', 'Telefone');
            }

            if (Schema::hasColumn('fornecedors', 'cnpj')) {
                $table->renameColumn('cnpj', 'CNPJ');
            }
        });
    }
};
