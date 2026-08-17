<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Service Categories (parent of Services) ----
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('service_categories')->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['Consultation', 'Procedure', 'Laboratory', 'Radiology', 'Pharmacy', 'Accommodation', 'Consumable', 'Equipment', 'Emergency', 'Other'])->default('Consultation');
            $table->string('color', 7)->default('#0f5132');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'type']);
        });

        // Add service_category_id to services table
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('service_category_id')->nullable()->after('category')->constrained()->nullOnDelete();
        });

        // ---- Procedure Categories ----
        Schema::create('procedure_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('specialty', ['General Surgery', 'Orthopaedics', 'OBGYN', 'ENT', 'Ophthalmology', 'Dental', 'Cardiology', 'Urology', 'Neurosurgery', 'Plastic Surgery', 'Paediatric Surgery', 'Endoscopy', 'Other'])->default('General Surgery');
            $table->text('description')->nullable();
            $table->boolean('requires_consent')->default(true);
            $table->boolean('requires_anaesthesia')->default(true);
            $table->boolean('requires_pre_op_assessment')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'specialty']);
        });

        // ---- Procedures (master list of surgical/medical procedures) ----
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('procedure_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('icd10_pcs_code')->nullable(); // ICD-10-PCS for procedures
            $table->string('cpt_code')->nullable(); // CPT code
            $table->enum('type', ['Minor', 'Major', 'Intermediate', 'Complex', 'Day Case'])->default('Minor');
            $table->enum('site', ['Theatre', 'Procedure Room', 'Ward Bedside', 'Consulting Room', 'Emergency Room', 'ICU', 'Other'])->default('Theatre');
            $table->enum('anaesthesia_type', ['Local', 'Regional', 'Spinal', 'Epidural', 'General', 'Sedation', 'None'])->default('Local');
            $table->integer('estimated_duration_minutes')->default(60);
            $table->integer('default_pre_op_days')->default(0);
            $table->integer('default_post_op_days')->default(1);
            $table->text('description')->nullable();
            $table->text('indication')->nullable();
            $table->text('contraindication')->nullable();
            $table->text('pre_op_instructions')->nullable();
            $table->text('post_op_instructions')->nullable();
            $table->text('complications')->nullable();
            $table->decimal('standard_fee', 14, 2)->default(0);
            $table->decimal('nhia_rate', 14, 2)->default(0);
            $table->decimal('private_rate', 14, 2)->default(0);
            $table->decimal('surgeon_fee', 14, 2)->default(0);
            $table->decimal('anaesthetist_fee', 14, 2)->default(0);
            $table->decimal('theatre_fee', 14, 2)->default(0);
            $table->decimal('consumables_fee', 14, 2)->default(0);
            $table->boolean('requires_pre_authorization')->default(false);
            $table->boolean('requires_blood_reservation')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'type']);
            $table->index('code');
        });

        // ---- Procedure Bookings (scheduling a procedure for a patient) ----
        Schema::create('procedure_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('admission_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('procedure_id')->constrained()->cascadeOnDelete();
            $table->foreignId('surgeon_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('anaesthetist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assistant_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('scrub_nurse_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('circulating_nurse_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('theatre_id')->nullable()->constrained('store_locations')->nullOnDelete();
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end')->nullable();
            $table->enum('priority', ['Elective', 'Urgent', 'Emergency'])->default('Elective');
            $table->enum('booking_status', ['Scheduled', 'Confirmed', 'In Progress', 'Completed', 'Cancelled', 'Postponed', 'No Show'])->default('Scheduled');
            // Pre-op
            $table->date('pre_op_assessment_date')->nullable();
            $table->boolean('consent_signed')->default(false);
            $table->dateTime('consent_signed_at')->nullable();
            $table->foreignId('consent_witnessed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('fasting_confirmed')->default(false);
            $table->boolean('investigations_done')->default(false);
            $table->boolean('anaesthesia_review_done')->default(false);
            $table->boolean('blood_reserved')->default(false);
            $table->text('pre_op_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'scheduled_start']);
            $table->index(['procedure_id', 'booking_status']);
            $table->index('booking_number');
        });

        // ---- Procedure Sessions (the actual performance of the procedure) ----
        Schema::create('procedure_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_number')->unique();
            $table->foreignId('procedure_booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('procedure_id')->constrained()->cascadeOnDelete();
            $table->foreignId('surgeon_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('anaesthetist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('theatre_id')->nullable()->constrained('store_locations')->nullOnDelete();
            $table->dateTime('actual_start');
            $table->dateTime('actual_end')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->enum('anaesthesia_used', ['Local', 'Regional', 'Spinal', 'Epidural', 'General', 'Sedation', 'None'])->default('Local');
            $table->text('anaesthesia_notes')->nullable();
            $table->text('findings_intra_op')->nullable();
            $table->text('procedure_performed')->nullable();
            $table->text('steps_taken')->nullable();
            $table->text('complications_intra_op')->nullable();
            $table->text('blood_loss_ml')->nullable();
            $table->text('specimens_sent')->nullable();
            $table->text('implants_used')->nullable();
            $table->text('drains_placed')->nullable();
            $table->text('dressing_applied')->nullable();
            $table->text('post_op_instructions')->nullable();
            $table->enum('outcome', ['Successful', 'Complicated', 'Incomplete', 'Abandoned', 'Death'])->default('Successful');
            $table->text('notes')->nullable();
            $table->boolean('is_signed')->default(false);
            $table->dateTime('signed_at')->nullable();
            $table->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['In Progress', 'Completed', 'Abandoned', 'Cancelled'])->default('In Progress');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['procedure_booking_id']);
            $table->index(['patient_id', 'actual_start']);
            $table->index('session_number');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['service_category_id']);
            $table->dropColumn('service_category_id');
        });

        Schema::dropIfExists('procedure_sessions');
        Schema::dropIfExists('procedure_bookings');
        Schema::dropIfExists('procedures');
        Schema::dropIfExists('procedure_categories');
        Schema::dropIfExists('service_categories');
    }
};
