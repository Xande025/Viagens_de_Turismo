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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('identification_name')->nullable();
            $table->string('bus_type')->nullable();
            $table->boolean('has_internet')->default(false);
            $table->boolean('has_wc')->default(false);
            $table->boolean('has_fridge')->default(false);
            $table->boolean('has_heater')->default(false);
            $table->boolean('has_video')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'identification_name',
                'bus_type',
                'has_internet',
                'has_wc',
                'has_fridge',
                'has_heater',
                'has_video'
            ]);
        });
    }
};
