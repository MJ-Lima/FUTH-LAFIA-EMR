<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Appointment Types ----
        Schema::create('appointment_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category', ['New', 'Follow-up', 'Review', 'Procedure', 'Telemedicine', 'Emergency', 'Specialist'])->default('New');
            $table->string('color', 7)->default('#0f5132');
            $table->integer('default_duration_minutes')->default(30);
            $table->decimal('default_fee', 14, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('requires_pre_auth')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'is_active']);
        });

        // ---- Clinic Schedules ----
        Schema::create('clinic_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('appointment_type_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('weekday', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->integer('slot_duration_minutes')->default(15);
            $table->integer('max_patients_per_slot')->default(1);
            $table->integer('buffer_minutes_before')->default(0);
            $table->integer('buffer_minutes_after')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['clinic_id', 'weekday', 'is_active']);
            $table->index(['hospital_id']);
        });

        // ---- Provider Schedules ----
        Schema::create('provider_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clinic_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('weekday', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->integer('slot_duration_minutes')->default(15);
            $table->integer('max_patients_per_slot')->default(1);
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'weekday', 'is_active']);
            $table->index(['hospital_id']);
        });

        // ---- Appointment Slots (generated from clinic/provider schedules) ----
        Schema::create('appointment_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('provider_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('appointment_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('clinic_schedule_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('provider_schedule_id')->nullable()->constrained()->nullOnDelete();
            $table->date('slot_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_minutes')->default(15);
            $table->integer('capacity')->default(1);
            $table->integer('booked_count')->default(0);
            $table->enum('status', ['Available', 'Booked', 'Blocked', 'Completed', 'Cancelled', 'No Show'])->default('Available');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['clinic_id', 'slot_date', 'status']);
            $table->index(['provider_id', 'slot_date']);
            $table->index(['slot_date', 'start_time']);
        });

        // ---- Holidays ----
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->date('holiday_date');
            $table->date('end_date')->nullable(); // for multi-day holidays
            $table->enum('type', ['Public Holiday', 'Religious', 'National', 'Hospital-specific', 'Local'])->default('Public Holiday');
            $table->boolean('is_working_day')->default(false);
            $table->boolean('affects_clinics')->default(true);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'holiday_date']);
        });

        // ---- Leave Requests ----
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->string('leave_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('leave_type', ['Annual', 'Sick', 'Casual', 'Maternity', 'Paternity', 'Compassionate', 'Study', 'Sabbatical', 'Unpaid', 'Other'])->default('Annual');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days_requested');
            $table->integer('days_approved')->nullable();
            $table->text('reason');
            $table->string('handover_to')->nullable();
            $table->text('handover_notes')->nullable();
            $table->json('attachment_paths')->nullable();
            $table->enum('status', ['Draft', 'Pending', 'Recommended', 'Approved', 'Rejected', 'Cancelled', 'On Leave', 'Returned'])->default('Pending');
            $table->foreignId('recommended_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('recommended_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['hospital_id', 'status']);
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('holidays');
        Schema::dropIfExists('appointment_slots');
        Schema::dropIfExists('provider_schedules');
        Schema::dropIfExists('clinic_schedules');
        Schema::dropIfExists('appointment_types');
    }
};
