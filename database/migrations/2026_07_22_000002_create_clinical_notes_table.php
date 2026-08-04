<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Clinical Notes — provider-authored narrative notes tied to an encounter.
 * Supports SOAP structure (Subjective, Objective, Assessment, Plan) — HL7 FHIR
 * ClinicalImpression / Composition inspired.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinical_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();

            $table->string('note_number')->unique();

            $table->enum('note_type', [
                'Progress',
                'Admission',
                'Discharge',
                'Nursing',
                'Procedure',
                'Consultation',
                'Referral',
                'Death',
                'Other',
            ])->default('Progress');

            $table->string('title')->nullable();

            // SOAP fields
            $table->longText('subjective')->nullable()->comment('S — patient-reported symptoms, history');
            $table->longText('objective')->nullable()->comment('O — examination findings, vitals observed');
            $table->longText('assessment')->nullable()->comment('A — diagnosis, clinical impression');
            $table->longText('plan')->nullable()->comment('P — treatment plan, orders, follow-up');

            $table->longText('narrative')->nullable()->comment('Free-form narrative note');
            $table->json('tags')->nullable();

            $table->boolean('is_signed')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'created_at']);
            $table->index(['encounter_id', 'note_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinical_notes');
    }
};
