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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            
            // Relação N:N entre Users e Events
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->foreignId('event_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Informações da inscrição
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                  ->default('confirmed');
            
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])
                  ->default('unpaid');
            
            $table->text('notes')->nullable(); // Notas do participante
            $table->timestamp('attended_at')->nullable(); // Check-in no evento
            
            $table->timestamps();
            
            // Prevenir inscrições duplicadas
            $table->unique(['user_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};