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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            
            // Relação com User (criador do evento)
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Relação com Category
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Informações do evento
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('location');
            $table->string('image')->nullable(); // Upload de imagem
            
            // Datas
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable(); // ← CORRIGIDO: agora é nullable
            
            // Capacidade
            $table->integer('max_participants')->default(100);
            $table->decimal('price', 8, 2)->default(0); // Preço (0 = grátis)
            
            // Status
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])
                  ->default('draft');
            
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};