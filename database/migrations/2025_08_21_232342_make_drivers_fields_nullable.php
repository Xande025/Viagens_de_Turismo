<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            // Tornar campos nullable para permitir cadastro sem dados obrigatórios
            $table->string('name')->nullable()->change();
            $table->string('cpf', 11)->nullable()->change();
            $table->string('cnh')->nullable()->change();
            $table->date('cnh_expiry')->nullable()->change();
        });
        
        // Executar comando SQL direto para alterar enum no PostgreSQL
        DB::statement('ALTER TABLE drivers ALTER COLUMN cnh_category DROP NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            // Reverter para campos obrigatórios
            $table->string('name')->nullable(false)->change();
            $table->string('cpf', 11)->nullable(false)->change();
            $table->string('cnh')->nullable(false)->change();
            $table->date('cnh_expiry')->nullable(false)->change();
        });
        
        // Reverter enum para not null
        DB::statement('ALTER TABLE drivers ALTER COLUMN cnh_category SET NOT NULL');
    }
};
