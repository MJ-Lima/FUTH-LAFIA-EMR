<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Wards ----
        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['General', 'Male Medical', 'Female Medical', 'Male Surgical', 'Female Surgical', 'Paediatrics', 'Maternity', 'Antenatal', 'Postnatal', 'ICU', 'HDU', 'NICU', 'Emergency', 'Isolation', 'Private', 'Psychiatry', 'Other'])->default('General');
            $table->enum('gender_restriction', ['Any', 'Male Only', 'Female Only', 'Paediatrics Only'])->default('Any');
            $table->integer('total_beds')->default(0);
            $table->string('floor')->nullable();
            $table->string('wing')->nullable();
            $table->decimal('daily_room_rate', 14, 2)->default(0);
            $table->foreignId('in_charge_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Closed', 'Maintenance'])->default('Active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'status']);
        });

        // ---- Beds ----
        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ward_id')->constrained()->cascadeOnDelete();
            $table->string('bed_number')->unique();
            $table->string('code')->nullable();
            $table->enum('type', ['Regular', 'Electric', 'ICU', 'HDU', 'Baby Cot', 'Stretchers', 'Recovery', 'Other'])->default('Regular');
            $table->enum('class', ['General', 'Private', 'Semi-Private', 'VIP', 'Suite'])->default('General');
            $table->decimal('daily_rate', 14, 2)->default(0);
            $table->enum('status', ['Available', 'Occupied', 'Reserved', 'Out of Service', 'Cleaning', 'Maintenance'])->default('Available');
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('current_admission_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['ward_id', 'status']);
            $table->index('bed_number');
        });

        // ---- Admissions ----
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('admission_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ward_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('bed_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('admitting_doctor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('attending_doctor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('admission_date');
            $table->dateTime('discharge_date')->nullable();
            $table->enum('admission_type', ['Emergency', 'Routine', 'Elective', 'Transfer In', 'Maternity', 'Day Case'])->default('Routine');
            $table->enum('admission_source', ['Emergency Room', 'Outpatient Clinic', 'Referral', 'Transfer', 'Direct Admission', 'Theatre'])->default('Outpatient Clinic');
            $table->text('admission_diagnosis')->nullable();
            $table->text('admission_reason')->nullable();
            $table->text('clinical_notes')->nullable();
            $table->enum('status', ['Admitted', 'Discharged', 'Transferred', 'Absconded', 'Death', 'Cancelled'])->default('Admitted');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'status']);
            $table->index(['patient_id', 'status']);
            $table->index(['ward_id', 'bed_id']);
            $table->index('admission_number');
        });

        // ---- Bed Transfers ----
        Schema::create('bed_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();
            $table->foreignId('admission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_ward_id')->nullable()->constrained('wards')->nullOnDelete();
            $table->foreignId('from_bed_id')->nullable()->constrained('beds')->nullOnDelete();
            $table->foreignId('to_ward_id')->constrained('wards')->cascadeOnDelete();
            $table->foreignId('to_bed_id')->nullable()->constrained('beds')->nullOnDelete();
            $table->dateTime('transfer_date');
            $table->text('reason')->nullable();
            $table->foreignId('authorized_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['admission_id']);
            $table->index(['patient_id', 'transfer_date']);
        });

        // ---- Discharge Summaries ----
        Schema::create('discharge_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('discharging_doctor_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('discharge_date');
            $table->enum('discharge_type', ['Improved', 'Recovered', 'Refused Treatment', 'Absconded', 'Transferred', 'Death', 'AMA', 'Other'])->default('Improved');
            $table->text('final_diagnosis')->nullable();
            $table->text('comorbidities')->nullable();
            $table->text('procedures_performed')->nullable();
            $table->text('investigations_summary')->nullable();
            $table->text('treatment_summary')->nullable();
            $table->text('treatment_given')->nullable();
            $table->text('condition_on_discharge')->nullable();
            $table->text('medications_on_discharge')->nullable();
            $table->text('follow_up_instructions')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->text('death_cause')->nullable();
            $table->time('death_time')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_signed')->default(false);
            $table->dateTime('signed_at')->nullable();
            $table->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['admission_id']);
            $table->index(['patient_id', 'discharge_date']);
        });

        // Add the FK from beds.current_admission_id → admissions.id (deferred because
        // admissions is created AFTER beds in this migration)
        Schema::table('beds', function (Blueprint $table) {
            $table->foreign('current_admission_id')->references('id')->on('admissions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discharge_summaries');
        Schema::dropIfExists('bed_transfers');
        Schema::dropIfExists('admissions');
        Schema::dropIfExists('beds');
        Schema::dropIfExists('wards');
    }
};
