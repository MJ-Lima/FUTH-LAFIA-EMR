<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Allergies & Adverse Reactions — HL7 FHIR AllergyIntolerance inspired.
 * Each row is one allergy/adverse reaction documented for a patient.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('allergies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();

            $table->string('substance')->comment('Allergen — drug class, food, environmental agent');
            $table->string('code')->nullable()->comment('SNOMED-CT / RxNorm / ICD-10 code if known');

            $table->enum('category', [
                'Medication',
                'Food',
                'Environment',
                'Biologic',
                'Other',
            ])->default('Medication');

            $table->enum('criticality', ['Low', 'High', 'Unable to assess'])->default('Low');

            $table->enum('severity', ['Mild', 'Moderate', 'Severe', 'Fatal'])->default('Mild');

            $table->enum('reaction', [
                'Rash',
                'Urticaria',
                'Anaphylaxis',
                'Angioedema',
                'Bronchospasm',
                'GI upset',
                'Hepatotoxicity',
                'Stevens-Johnson',
                'Other',
            ])->default('Rash');

            $table->text('reaction_description')->nullable();
            $table->date('onset_date')->nullable();
            $table->text('notes')->nullable();

            $table->enum('status', ['Active', 'Resolved', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->index(['patient_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('allergies');
    }
};
