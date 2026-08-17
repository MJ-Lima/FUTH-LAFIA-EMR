<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_insurance_id')->constrained('patient_insurance')->cascadeOnDelete();
            $table->foreignId('insurance_provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('insurance_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->date('service_date_start');
            $table->date('service_date_end');
            $table->enum('claim_type', ['Outpatient', 'Inpatient', 'Emergency', 'Pharmacy', 'Laboratory', 'Radiology', 'Procedure', 'Maternity'])->default('Outpatient');
            $table->string('diagnosis_icd10')->nullable();
            $table->text('diagnosis_description')->nullable();
            $table->text('treatment_summary')->nullable();
            $table->decimal('total_claimed', 14, 2)->default(0);
            $table->decimal('total_approved', 14, 2)->default(0);
            $table->decimal('total_paid', 14, 2)->default(0);
            $table->decimal('patient_copay', 14, 2)->default(0);
            $table->decimal('deduction', 14, 2)->default(0);
            $table->string('pre_authorization_code')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'Acknowledged', 'Processing', 'Approved', 'Partially Approved', 'Rejected', 'Paid', 'Reversed'])->default('Draft');
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('acknowledged_at')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'status']);
            $table->index(['patient_id', 'status']);
            $table->index(['insurance_provider_id', 'status']);
            $table->index('claim_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_claims');
    }
};
