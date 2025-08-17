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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('origin'); // Origem
            $table->string('destination'); // Destino
            $table->datetime('departure_time'); // Horário de partida
            $table->datetime('arrival_time'); // Horário de chegada
            $table->foreignId('vehicle_id')->constrained(); // Veículo
            $table->foreignId('driver_id')->constrained(); // Motorista
            $table->integer('passenger_count'); // Número de passageiros
            $table->decimal('price', 8, 2); // Preço
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled'); // Status
            $table->text('description')->nullable(); // Descrição adicional
            $table->text('observations')->nullable(); // Observações
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
