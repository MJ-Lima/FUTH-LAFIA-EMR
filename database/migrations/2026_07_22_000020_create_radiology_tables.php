<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Radiology — modalities, orders, results.
 * HL7 FHIR ImagingStudy + DiagnosticReport inspired. DICOM modality codes used.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('radiology_modalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 10)->unique()->comment('DICOM modality code: XRAY, CT, MR, US, NM, PT, etc.');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('turnaround_hours')->default(24);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('radiology_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('modality_id')->constrained('radiology_modalities')->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('order_number')->unique();
            $table->dateTime('ordered_at');
            $table->dateTime('performed_at')->nullable();
            $table->dateTime('resulted_at')->nullable();

            $table->string('examination')->comment('e.g. Chest X-Ray PA view, CT Brain plain');
            $table->string('body_part')->nullable();
            $table->text('clinical_indication')->nullable();
            $table->text('request_notes')->nullable();

            $table->enum('priority', ['Routine', 'Urgent', 'STAT'])->default('Routine');
            $table->enum('status', [
                'Pending',
                'Scheduled',
                'In Progress',
                'Completed',
                'Verified',
                'Cancelled',
            ])->default('Pending');

            $table->timestamps();
            $table->softDeletes();
            $table->index(['patient_id', 'ordered_at']);
        });

        Schema::create('radiology_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('radiology_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->text('findings');
            $table->text('impression')->nullable();
            $table->text('recommendations')->nullable();
            $table->json('images')->nullable()->comment('Stored paths/URLs to DICOM / JPG / PDF');

            $table->dateTime('reported_at')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radiology_results');
        Schema::dropIfExists('radiology_orders');
        Schema::dropIfExists('radiology_modalities');
    }
};
