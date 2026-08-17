<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Add biometric fields to patients ----
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'photo_path')) {
                $table->string('photo_path')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('patients', 'thumbprint_path')) {
                $table->string('thumbprint_path')->nullable()->after('photo_path');
            }
            if (!Schema::hasColumn('patients', 'thumbprint_data')) {
                $table->longText('thumbprint_data')->nullable()->after('thumbprint_path');
            }
            if (!Schema::hasColumn('patients', 'biometric_captured_at')) {
                $table->dateTime('biometric_captured_at')->nullable()->after('thumbprint_data');
            }
            if (!Schema::hasColumn('patients', 'biometric_captured_by')) {
                $table->foreignId('biometric_captured_by')->nullable()->constrained('users')->nullOnDelete()->after('biometric_captured_at');
            }
            if (!Schema::hasColumn('patients', 'verification_status')) {
                $table->enum('verification_status', ['Pending', 'Verified', 'Rejected', 'Expired'])->default('Pending')->after('biometric_captured_by');
            }
            if (!Schema::hasColumn('patients', 'verified_at')) {
                $table->dateTime('verified_at')->nullable()->after('verification_status');
            }
            if (!Schema::hasColumn('patients', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('verified_at');
            }
            if (!Schema::hasColumn('patients', 'national_id')) {
                $table->string('national_id', 50)->nullable()->after('patientcode');
            }
            if (!Schema::hasColumn('patients', 'national_id_type')) {
                $table->enum('national_id_type', ['NIN', 'Voter Card', 'Driver License', 'International Passport', 'Birth Certificate', 'Other'])->nullable()->after('national_id');
            }
        });

        // ---- Patient Dependants (for insurance) ----
        Schema::create('patient_dependants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('principal_patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->foreignId('patient_insurance_id')->nullable()->constrained('patient_insurance')->nullOnDelete();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('relationship', ['Spouse', 'Child', 'Parent', 'Sibling', 'Dependant', 'Other']);
            $table->string('national_id')->nullable();
            $table->enum('national_id_type', ['NIN', 'Voter Card', 'Driver License', 'International Passport', 'Birth Certificate', 'Other'])->nullable();
            $table->string('photo_path')->nullable();
            $table->string('thumbprint_path')->nullable();
            $table->longText('thumbprint_data')->nullable();
            $table->dateTime('biometric_captured_at')->nullable();
            $table->foreignId('biometric_captured_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('verification_status', ['Pending', 'Verified', 'Rejected', 'Expired'])->default('Pending');
            $table->dateTime('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Suspended'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['principal_patient_id']);
            $table->index(['patient_insurance_id']);
            $table->index('verification_status');
        });

        // ---- Patient Relationship Manager ----
        Schema::create('relationship_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category', ['Family', 'Medical', 'Financial', 'Legal', 'Insurance', 'Referral', 'Emergency', 'Other'])->default('Family');
            $table->text('description')->nullable();
            $table->boolean('is_symmetric')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('patient_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->foreignId('relationship_type_id')->constrained()->cascadeOnDelete();
            $table->string('related_party_name')->nullable();
            $table->string('related_party_phone', 30)->nullable();
            $table->string('related_party_email')->nullable();
            $table->text('related_party_address')->nullable();
            $table->text('notes')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_primary_contact')->default(false);
            $table->boolean('is_emergency_contact')->default(false);
            $table->boolean('can_make_decisions')->default(false);
            $table->enum('status', ['Active', 'Inactive', 'Terminated'])->default('Active');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['patient_id', 'related_patient_id']);
            $table->index(['relationship_type_id']);
            $table->index(['is_emergency_contact']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_relationships');
        Schema::dropIfExists('relationship_types');
        Schema::dropIfExists('patient_dependants');

        Schema::table('patients', function (Blueprint $table) {
            $columns = ['photo_path', 'thumbprint_path', 'thumbprint_data', 'biometric_captured_at', 'biometric_captured_by', 'verification_status', 'verified_at', 'verified_by', 'national_id', 'national_id_type'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('patients', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
