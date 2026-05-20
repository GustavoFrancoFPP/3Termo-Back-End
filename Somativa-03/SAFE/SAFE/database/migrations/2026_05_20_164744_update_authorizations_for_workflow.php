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
        Schema::table('authorizations', function (Blueprint $table) {
            // Adicionar admin_id e professor_id (decision makers)
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null')->after('teacher_id');
            $table->foreignId('professor_id')->nullable()->constrained('users')->onDelete('set null')->after('admin_id');
            // Adicionar status e data para análise do professor
            $table->timestamp('analyzed_by_professor_at')->nullable()->after('validated_at');
            $table->string('professor_decision')->nullable()->after('analyzed_by_professor_at'); // 'approved', 'rejected'
            $table->text('professor_notes')->nullable()->after('professor_decision');
            // Rastreamento da portaria
            $table->timestamp('checked_by_portaria_at')->nullable()->after('professor_notes');
            $table->string('portaria_status')->nullable()->after('checked_by_portaria_at'); // 'checked', 'denied'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authorizations', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['admin_id']);
            $table->dropForeign(['professor_id']);
            // Drop columns
            $table->dropColumn([
                'admin_id', 'professor_id', 'analyzed_by_professor_at', 
                'professor_decision', 'professor_notes', 
                'checked_by_portaria_at', 'portaria_status'
            ]);
        });
    }
};
