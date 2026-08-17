<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Report Templates ----
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category', [
                'Patient', 'Clinical', 'Financial', 'Pharmacy', 'Laboratory',
                'Radiology', 'Insurance', 'HR', 'Inventory', 'Audit',
                'Mortality', 'Morbidity', 'Infection', 'Quality', 'Operational', 'Other'
            ])->default('Patient');
            $table->enum('frequency', ['On Demand', 'Daily', 'Weekly', 'Monthly', 'Quarterly', 'Annual'])->default('On Demand');
            $table->text('description')->nullable();
            $table->json('parameters')->nullable();
            $table->json('columns')->nullable();
            $table->json('filters')->nullable();
            $table->json('group_by')->nullable();
            $table->json('chart_config')->nullable();
            $table->string('data_source')->nullable();
            $table->text('sql_query')->nullable();
            $table->boolean('is_scheduled')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'category']);
            $table->index(['frequency']);
        });

        // ---- Saved Reports (generated report instances) ----
        Schema::create('saved_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('report_template_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->enum('category', ['Patient', 'Clinical', 'Financial', 'Pharmacy', 'Laboratory', 'Radiology', 'Insurance', 'HR', 'Inventory', 'Audit', 'Mortality', 'Morbidity', 'Infection', 'Quality', 'Operational', 'Other'])->default('Patient');
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('clinic_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('parameters')->nullable();
            $table->json('data')->nullable();
            $table->json('summary')->nullable();
            $table->integer('record_count')->default(0);
            $table->decimal('total_value', 18, 2)->nullable();
            $table->string('file_path')->nullable();
            $table->enum('format', ['HTML', 'PDF', 'Excel', 'CSV', 'JSON'])->default('HTML');
            $table->enum('status', ['Generating', 'Completed', 'Failed', 'Archived'])->default('Generating');
            $table->text('error_message')->nullable();
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->dateTime('generated_at');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'category']);
            $table->index(['period_from', 'period_to']);
            $table->index(['department_id']);
            $table->index(['user_id']);
        });

        // ---- Report Schedules ----
        Schema::create('report_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('report_template_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('frequency', ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Annual'])->default('Monthly');
            $table->time('run_at')->default('08:00:00');
            $table->integer('day_of_week')->nullable();
            $table->integer('day_of_month')->nullable();
            $table->integer('month_of_quarter')->nullable();
            $table->json('parameters')->nullable();
            $table->json('recipients')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('last_run_at')->nullable();
            $table->dateTime('next_run_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['next_run_at', 'is_active']);
        });

        // ---- Report Subscriptions (users who receive reports) ----
        Schema::create('report_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('report_template_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('report_schedule_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('delivery_method', ['Email', 'In-App', 'Both'])->default('Email');
            $table->json('filter_preferences')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['user_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_subscriptions');
        Schema::dropIfExists('report_schedules');
        Schema::dropIfExists('saved_reports');
        Schema::dropIfExists('report_templates');
    }
};
