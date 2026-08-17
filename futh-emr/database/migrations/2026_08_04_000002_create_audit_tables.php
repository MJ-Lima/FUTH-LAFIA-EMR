<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Audit Categories ----
        Schema::create('audit_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['Medical', 'Internal', 'Financial', 'Operational', 'Compliance', 'IT', 'Clinical', 'Pharmacy', 'Laboratory', 'Nursing', 'Other'])->default('Medical');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'type']);
        });

        // ---- Medical Audits ----
        Schema::create('medical_audits', function (Blueprint $table) {
            $table->id();
            $table->string('audit_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('audit_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('clinic_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('admission_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('auditor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('audit_type', [
                'Case Review', 'Mortality Review', 'Morbidity Review',
                'Documentation Audit', 'Prescription Audit', 'Lab Utilization',
                'Infection Control', 'Patient Safety', 'Clinical Guideline Compliance',
                'Surgical Audit', 'Medication Safety', 'Other'
            ])->default('Case Review');
            $table->date('audit_date');
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();
            $table->text('audit_scope')->nullable();
            $table->text('objectives')->nullable();
            $table->text('methodology')->nullable();
            $table->text('summary')->nullable();
            $table->text('key_findings')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('action_plan')->nullable();
            $table->enum('risk_level', ['Low', 'Moderate', 'High', 'Critical'])->default('Low');
            $table->enum('status', ['Planned', 'In Progress', 'Completed', 'Reviewed', 'Closed', 'Cancelled'])->default('Planned');
            $table->date('review_date')->nullable();
            $table->text('review_notes')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'status']);
            $table->index(['audit_type', 'audit_date']);
            $table->index(['auditor_id']);
        });

        // ---- Medical Audit Findings ----
        Schema::create('medical_audit_findings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_audit_id')->constrained()->cascadeOnDelete();
            $table->string('finding_number');
            $table->enum('category', ['Clinical', 'Documentation', 'Medication', 'Procedure', 'Diagnostic', 'Communication', 'Follow-up', 'Other'])->default('Clinical');
            $table->string('title');
            $table->text('description');
            $table->text('criteria')->nullable();
            $table->text('condition_observed')->nullable();
            $table->text('cause')->nullable();
            $table->text('effect')->nullable();
            $table->enum('severity', ['Minor', 'Moderate', 'Major', 'Critical'])->default('Minor');
            $table->enum('risk_level', ['Low', 'Moderate', 'High', 'Critical'])->default('Low');
            $table->text('recommendation')->nullable();
            $table->text('corrective_action')->nullable();
            $table->foreignId('responsible_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('target_completion_date')->nullable();
            $table->enum('status', ['Open', 'In Progress', 'Implemented', 'Verified', 'Closed'])->default('Open');
            $table->date('date_closed')->nullable();
            $table->text('closure_notes')->nullable();
            $table->timestamps();
            $table->index(['medical_audit_id', 'status']);
            $table->index(['severity']);
        });

        // ---- Internal Audits ----
        Schema::create('internal_audits', function (Blueprint $table) {
            $table->id();
            $table->string('audit_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('audit_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('auditor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lead_auditor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('audit_type', [
                'Financial', 'Operational', 'Compliance', 'IT', 'HR',
                'Procurement', 'Inventory', 'Revenue Cycle', 'Payroll',
                'Asset Management', 'Risk Management', 'Other'
            ])->default('Financial');
            $table->date('audit_date');
            $table->date('period_from');
            $table->date('period_to');
            $table->text('audit_scope');
            $table->text('objectives')->nullable();
            $table->text('methodology')->nullable();
            $table->text('documents_reviewed')->nullable();
            $table->text('persons_interviewed')->nullable();
            $table->text('summary')->nullable();
            $table->text('key_findings')->nullable();
            $table->text('recommendations')->nullable();
            $table->text('management_response')->nullable();
            $table->text('action_plan')->nullable();
            $table->decimal('financial_impact', 18, 2)->default(0);
            $table->enum('risk_level', ['Low', 'Moderate', 'High', 'Critical'])->default('Low');
            $table->enum('status', ['Planned', 'In Progress', 'Draft Report', 'Final Report', 'Management Response', 'Action Plan', 'Closed', 'Cancelled'])->default('Planned');
            $table->date('report_date')->nullable();
            $table->date('management_response_date')->nullable();
            $table->date('final_report_date')->nullable();
            $table->date('closure_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'status']);
            $table->index(['audit_type', 'audit_date']);
        });

        // ---- Internal Audit Findings ----
        Schema::create('internal_audit_findings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internal_audit_id')->constrained()->cascadeOnDelete();
            $table->string('finding_number');
            $table->enum('category', ['Financial', 'Operational', 'Compliance', 'IT', 'HR', 'Procurement', 'Other'])->default('Financial');
            $table->string('title');
            $table->text('description');
            $table->text('criteria')->nullable();
            $table->text('condition_observed')->nullable();
            $table->text('cause')->nullable();
            $table->text('effect')->nullable();
            $table->text('evidence')->nullable();
            $table->decimal('financial_impact', 18, 2)->default(0);
            $table->enum('severity', ['Minor', 'Moderate', 'Major', 'Critical'])->default('Minor');
            $table->enum('risk_level', ['Low', 'Moderate', 'High', 'Critical'])->default('Low');
            $table->text('recommendation')->nullable();
            $table->text('management_response')->nullable();
            $table->text('corrective_action')->nullable();
            $table->foreignId('responsible_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->date('target_completion_date')->nullable();
            $table->enum('status', ['Open', 'In Progress', 'Implemented', 'Verified', 'Closed', 'Rejected'])->default('Open');
            $table->date('date_closed')->nullable();
            $table->text('closure_notes')->nullable();
            $table->timestamps();
            $table->index(['internal_audit_id', 'status']);
            $table->index(['severity']);
        });

        // ---- Audit Follow-ups ----
        Schema::create('audit_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->string('follow_up_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->enum('audit_type', ['Medical', 'Internal'])->default('Medical');
            $table->foreignId('medical_audit_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('internal_audit_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('finding_id')->nullable();
            $table->foreignId('followed_up_by')->constrained('users')->cascadeOnDelete();
            $table->date('follow_up_date');
            $table->text('progress_notes');
            $table->text('evidence_provided')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('progress_status', ['Not Started', 'In Progress', 'Delayed', 'Completed', 'Overdue'])->default('In Progress');
            $table->integer('completion_percentage')->default(0);
            $table->date('next_follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['medical_audit_id']);
            $table->index(['internal_audit_id']);
            $table->index(['follow_up_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_follow_ups');
        Schema::dropIfExists('internal_audit_findings');
        Schema::dropIfExists('internal_audits');
        Schema::dropIfExists('medical_audit_findings');
        Schema::dropIfExists('medical_audits');
        Schema::dropIfExists('audit_categories');
    }
};
