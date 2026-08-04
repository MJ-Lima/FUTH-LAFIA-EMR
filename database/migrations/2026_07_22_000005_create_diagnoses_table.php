<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Diagnoses — HL7 FHIR Condition inspired.
 * Encoded against ICD-10 (WHO international standard). Linked to encounters.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();

            $table->string('icd10_code', 10)->index()->comment('ICD-10 WHO code');
            $table->string('description');
            $table->enum('type', ['Principal', 'Admitting', 'Working', 'Discharge', 'Secondary', 'Comorbidity'])->default('Working');
            $table->enum('status', ['Active', 'Resolved', 'Chronic', 'Recurrent'])->default('Active');
            $table->date('onset_date')->nullable();
            $table->date('resolved_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
