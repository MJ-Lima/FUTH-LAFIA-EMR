<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('admission_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->enum('requested_blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Unknown']);
            $table->enum('component_requested', ['Whole Blood', 'Packed Red Cells', 'Plasma', 'Platelets', 'Cryoprecipitate', 'Fresh Frozen Plasma'])->default('Whole Blood');
            $table->decimal('units_requested', 6, 0)->default(1);
            $table->enum('urgency', ['Routine', 'Urgent', 'Emergency', 'STAT'])->default('Routine');
            $table->dateTime('required_by');
            $table->text('clinical_indication')->nullable();
            $table->text('diagnosis')->nullable();
            $table->decimal('patient_hb_level', 5, 1)->nullable();
            $table->enum('patient_blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Unknown'])->default('Unknown');
            $table->enum('patient_rh_factor', ['Positive', 'Negative', 'Unknown'])->default('Unknown');
            $table->text('crossmatch_notes')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Crossmatched', 'Issued', 'Transfused', 'Cancelled', 'Rejected'])->default('Pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('crossmatched_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('crossmatched_at')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('issued_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['patient_id', 'status']);
            $table->index(['requested_blood_group', 'component_requested', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('blood_requests'); }
};
