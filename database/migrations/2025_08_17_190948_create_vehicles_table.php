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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate')->unique(); // Placa do veículo
            $table->string('model'); // Modelo
            $table->string('brand'); // Marca
            $table->year('year'); // Ano
            $table->integer('capacity'); // Capacidade de passageiros
            $table->enum('status', ['available', 'in_use', 'maintenance'])->default('available'); // Status
            $table->text('description')->nullable(); // Descrição adicional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
