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
        Schema::create('safe_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('authorization_id');
            $table->unsignedBigInteger('guardian_id');
            $table->enum('channel', ['email', 'whatsapp', 'log']);
            $table->enum('type', ['authorization_request', 'entry_notification', 'exit_notification', 'rejection_notification']);
            $table->text('message');
            $table->enum('status', ['pending', 'sent', 'failed']);
            $table->text('response')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->foreign('authorization_id')->references('id')->on('authorizations')->onDelete('cascade');
            $table->foreign('guardian_id')->references('id')->on('guardians')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safe_notifications');
    }
};
