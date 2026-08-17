<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('blood_units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donation_id')->constrained('blood_donations')->cascadeOnDelete();
            $table->foreignId('donor_id')->constrained('blood_donors')->cascadeOnDelete();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->enum('component_type', ['Whole Blood', 'Packed Red Cells', 'Plasma', 'Platelets', 'Cryoprecipitate', 'Fresh Frozen Plasma'])->default('Whole Blood');
            $table->decimal('volume_ml', 6, 0)->default(450);
            $table->date('collection_date');
            $table->date('expiry_date');
            $table->string('storage_location')->nullable();
            $table->decimal('storage_temperature_c', 4, 1)->default(4.0);
            $table->enum('hiv_status', ['Pending', 'Negative', 'Positive', 'Not Tested'])->default('Pending');
            $table->enum('hepatitis_b_status', ['Pending', 'Negative', 'Positive', 'Not Tested'])->default('Pending');
            $table->enum('hepatitis_c_status', ['Pending', 'Negative', 'Positive', 'Not Tested'])->default('Pending');
            $table->enum('syphilis_status', ['Pending', 'Negative', 'Positive', 'Not Tested'])->default('Pending');
            $table->enum('malaria_status', ['Pending', 'Negative', 'Positive', 'Not Tested'])->default('Pending');
            $table->text('screening_notes')->nullable();
            $table->foreignId('screened_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('screened_at')->nullable();
            $table->boolean('is_screened')->default(false);
            $table->boolean('is_quarantined')->default(false);
            $table->enum('status', ['Collected', 'Screening', 'Available', 'Reserved', 'Transfused', 'Discarded', 'Expired'])->default('Collected');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['blood_group', 'component_type', 'status']);
            $table->index('expiry_date');
        });
    }
    public function down(): void { Schema::dropIfExists('blood_units'); }
};
