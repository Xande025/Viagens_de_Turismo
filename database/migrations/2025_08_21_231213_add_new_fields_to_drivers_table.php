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
        Schema::table('drivers', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('name');
            $table->string('registration')->nullable()->after('birth_date');
            $table->string('rg')->nullable()->after('cpf');
            $table->string('zip_code')->nullable()->after('email');
            $table->string('address')->nullable()->after('zip_code');
            $table->string('number')->nullable()->after('address');
            $table->string('city')->nullable()->after('number');
            $table->string('state')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date',
                'registration', 
                'rg',
                'zip_code',
                'address',
                'number',
                'city',
                'state'
            ]);
        });
    }
};
