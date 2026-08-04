<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Lab Catalog: lab tests & panels that the lab department can perform.
 * LOINC codes used where applicable (international standard for lab observations).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_panels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('loinc_code', 20)->nullable()->index();
            $table->string('specimen_type')->nullable()->comment('Blood, Urine, Sputum, etc.');
            $table->string('container')->nullable()->comment('EDTA, Plain, Fluoride, etc.');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('turnaround_hours')->default(24);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lab_panel_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name');
            $table->string('code')->unique();
            $table->string('loinc_code', 20)->nullable()->index();
            $table->string('specimen_type')->nullable();
            $table->string('container')->nullable();
            $table->string('unit')->nullable()->comment('g/dL, mg/L, mmol/L, etc.');
            $table->string('reference_range_low')->nullable();
            $table->string('reference_range_high')->nullable();
            $table->text('reference_notes')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('turnaround_hours')->default(24);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('lab_panels');
    }
};
