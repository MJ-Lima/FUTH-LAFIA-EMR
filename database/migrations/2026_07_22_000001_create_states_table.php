<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Nigerian States + LGAs reference data (used by patient registration).
 * Aligns with ISO 3166-2:NG subdivision codes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id('state_id');
            $table->string('name')->unique();
            $table->string('code', 10)->unique()->comment('ISO 3166-2:NG subdivision code');
            $table->timestamps();
        });

        Schema::create('locals', function (Blueprint $table) {
            $table->id('local_id');
            $table->foreignId('state_id')->constrained('states', 'state_id')->cascadeOnDelete();
            $table->string('local_name');
            $table->timestamps();
            $table->unique(['state_id', 'local_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locals');
        Schema::dropIfExists('states');
    }
};
