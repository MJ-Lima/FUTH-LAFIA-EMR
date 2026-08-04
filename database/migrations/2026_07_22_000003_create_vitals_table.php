<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Vitals / Clinical Observations — HL7 FHIR Observation resource inspired.
 * Stores numeric vital signs tied to an encounter or as a standalone measurement.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();

            $table->dateTime('recorded_at');

            // Anthropometric
            $table->decimal('height_cm', 5, 2)->nullable();
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->decimal('bmi', 5, 2)->nullable()->comment('Computed automatically');
            $table->decimal('muac_cm', 5, 2)->nullable()->comment('Mid-upper arm circumference');

            // Cardiovascular
            $table->unsignedSmallInteger('systolic_bp')->nullable();
            $table->unsignedSmallInteger('diastolic_bp')->nullable();
            $table->unsignedSmallInteger('heart_rate')->nullable()->comment('bpm');
            $table->enum('bp_position', ['Sitting', 'Standing', 'Supine', 'Unknown'])->default('Unknown');

            // Respiratory
            $table->unsignedSmallInteger('respiratory_rate')->nullable()->comment('breaths/min');
            $table->unsignedSmallInteger('spo2')->nullable()->comment('% oxygen saturation');

            // Thermoregulation
            $table->decimal('temperature_c', 4, 2)->nullable()->comment('Celsius');
            $table->enum('temperature_route', ['Oral', 'Axillary', 'Tympanic', 'Rectal', 'Forehead'])->default('Oral');

            // Neurological
            $table->unsignedSmallInteger('pain_score')->nullable()->comment('0-10 scale');
            $table->string('glasgow_coma_score', 8)->nullable();

            // Glucose
            $table->decimal('blood_glucose_mmol_l', 5, 2)->nullable();
            $table->enum('glucose_fasting', ['Fasting', 'Random', 'Postprandial', 'Unknown'])->default('Unknown');

            // Maternal (when applicable)
            $table->unsignedSmallInteger('fetal_heart_rate')->nullable();
            $table->decimal('fundal_height_cm', 5, 2)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->index(['patient_id', 'recorded_at']);
            $table->index('encounter_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
};
