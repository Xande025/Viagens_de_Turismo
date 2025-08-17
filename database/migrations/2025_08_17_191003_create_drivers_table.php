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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do motorista
            $table->string('cpf', 11)->unique(); // CPF
            $table->string('cnh')->unique(); // CNH
            $table->enum('cnh_category', ['A', 'B', 'C', 'D', 'E']); // Categoria da CNH
            $table->date('cnh_expiry'); // Validade da CNH
            $table->string('phone')->nullable(); // Telefone
            $table->string('email')->unique()->nullable(); // Email
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
