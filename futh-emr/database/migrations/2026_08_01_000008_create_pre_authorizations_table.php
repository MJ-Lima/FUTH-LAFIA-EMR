<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pre_authorizations', function (Blueprint $table) {
            $table->id();
            $table->string('authorization_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_insurance_id')->constrained('patient_insurance')->cascadeOnDelete();
            $table->foreignId('insurance_provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->enum('service_type', ['Consultation', 'Pharmacy', 'Laboratory', 'Radiology', 'Procedure', 'Surgery', 'Inpatient Admission', 'Maternity', 'Specialist Referral', 'Other'])->default('Consultation');
            $table->text('clinical_justification');
            $table->string('diagnosis_icd10')->nullable();
            $table->text('diagnosis_description')->nullable();
            $table->decimal('estimated_cost', 14, 2)->default(0);
            $table->decimal('approved_amount', 14, 2)->default(0);
            $table->date('requested_date');
            $table->date('required_by_date')->nullable();
            $table->date('authorized_date')->nullable();
            $table->date('valid_until')->nullable();
            $table->enum('priority', ['Routine', 'Urgent', 'Emergency'])->default('Routine');
            $table->enum('status', ['Pending', 'Approved', 'Partially Approved', 'Rejected', 'Expired', 'Utilized', 'Cancelled'])->default('Pending');
            $table->text('provider_response')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'status']);
            $table->index(['patient_id', 'status']);
            $table->index(['insurance_provider_id', 'status']);
            $table->index('authorization_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pre_authorizations');
    }
};
