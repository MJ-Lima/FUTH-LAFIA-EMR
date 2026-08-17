<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Drug Categories
        if (!Schema::hasTable('drug_categories')) {
            Schema::create('drug_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Drugs
        if (!Schema::hasTable('drugs')) {
            Schema::create('drugs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('drug_category_id')->nullable()->constrained()->nullOnDelete();
                $table->string('name');
                $table->string('generic_name')->nullable();
                $table->string('code')->unique();
                $table->string('atc_code')->nullable();
                $table->string('dosage_form')->nullable();
                $table->string('strength')->nullable();
                $table->string('unit_of_measure')->nullable();
                $table->string('manufacturer')->nullable();
                $table->string('supplier')->nullable();
                $table->decimal('cost_price', 12, 2)->default(0);
                $table->decimal('selling_price', 12, 2)->default(0);
                $table->decimal('reorder_level', 12, 2)->default(0);
                $table->decimal('reorder_quantity', 12, 2)->default(0);
                $table->boolean('is_controlled')->default(false);
                $table->boolean('is_antenatal_safe')->default(false);
                $table->boolean('is_pediatric_safe')->default(false);
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Drug Batches
        if (!Schema::hasTable('drug_batches')) {
            Schema::create('drug_batches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
                $table->string('batch_number');
                $table->date('expiry_date')->nullable();
                $table->date('manufactured_date')->nullable();
                $table->decimal('quantity_received', 12, 2)->default(0);
                $table->decimal('quantity_remaining', 12, 2)->default(0);
                $table->decimal('cost_price', 12, 2)->default(0);
                $table->string('supplier')->nullable();
                $table->date('received_date')->nullable();
                $table->boolean('is_quarantined')->default(false);
                $table->timestamps();
            });
        }

        // Suppliers
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('contact_person')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('tax_id')->nullable();
                $table->string('registration_number')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Dispensing Points
        if (!Schema::hasTable('dispensing_points')) {
            Schema::create('dispensing_points', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('location')->nullable();
                $table->foreignId('in_charge_id')->nullable()->constrained('users')->nullOnDelete();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        // Lab Panels
        if (!Schema::hasTable('lab_panels')) {
            Schema::create('lab_panels', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('loinc_code')->nullable();
                $table->string('specimen_type')->nullable();
                $table->string('container')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price', 14, 2)->default(0);
                $table->integer('turnaround_hours')->default(24);
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Lab Tests
        if (!Schema::hasTable('lab_tests')) {
            Schema::create('lab_tests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('lab_panel_id')->nullable()->constrained()->nullOnDelete();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('loinc_code')->nullable();
                $table->string('specimen_type')->nullable();
                $table->string('container')->nullable();
                $table->string('unit')->nullable();
                $table->decimal('reference_range_low', 10, 2)->nullable();
                $table->decimal('reference_range_high', 10, 2)->nullable();
                $table->string('reference_notes')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price', 14, 2)->default(0);
                $table->integer('turnaround_hours')->default(24);
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Radiology Modalities
        if (!Schema::hasTable('radiology_modalities')) {
            Schema::create('radiology_modalities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->decimal('price', 14, 2)->default(0);
                $table->integer('turnaround_hours')->default(24);
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        // Vitals
        if (!Schema::hasTable('vitals')) {
            Schema::create('vitals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
                $table->dateTime('recorded_at');
                $table->decimal('height_cm', 5, 2)->nullable();
                $table->decimal('weight_kg', 5, 2)->nullable();
                $table->decimal('bmi', 5, 2)->nullable();
                $table->decimal('muac_cm', 5, 2)->nullable();
                $table->smallInteger('systolic_bp')->nullable();
                $table->smallInteger('diastolic_bp')->nullable();
                $table->smallInteger('heart_rate')->nullable();
                $table->enum('bp_position', ['Sitting', 'Standing', 'Supine', 'Unknown'])->default('Unknown');
                $table->smallInteger('respiratory_rate')->nullable();
                $table->smallInteger('spo2')->nullable();
                $table->decimal('temperature_c', 4, 2)->nullable();
                $table->enum('temperature_route', ['Oral', 'Axillary', 'Tympanic', 'Rectal', 'Forehead'])->default('Oral');
                $table->smallInteger('pain_score')->nullable();
                $table->string('glasgow_coma_score', 8)->nullable();
                $table->decimal('blood_glucose_mmol_l', 5, 2)->nullable();
                $table->enum('glucose_fasting', ['Fasting', 'Random', 'Postprandial', 'Unknown'])->default('Unknown');
                $table->smallInteger('fetal_heart_rate')->nullable();
                $table->decimal('fundal_height_cm', 5, 2)->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Clinical Notes
        if (!Schema::hasTable('clinical_notes')) {
            Schema::create('clinical_notes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
                $table->string('note_number')->unique();
                $table->enum('note_type', ['Progress', 'Admission', 'Discharge', 'Nursing', 'Procedure', 'Consultation', 'Referral', 'Death', 'Other'])->default('Progress');
                $table->string('title')->nullable();
                $table->longText('subjective')->nullable();
                $table->longText('objective')->nullable();
                $table->longText('assessment')->nullable();
                $table->longText('plan')->nullable();
                $table->longText('narrative')->nullable();
                $table->longText('tags')->nullable();
                $table->boolean('is_signed')->default(false);
                $table->dateTime('signed_at')->nullable();
                $table->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Allergies
        if (!Schema::hasTable('allergies')) {
            Schema::create('allergies', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
                $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
                $table->string('substance');
                $table->string('code')->nullable();
                $table->enum('category', ['Medication', 'Food', 'Environment', 'Biologic', 'Other'])->default('Medication');
                $table->enum('criticality', ['Low', 'High', 'Unable to assess'])->default('Low');
                $table->enum('severity', ['Mild', 'Moderate', 'Severe', 'Fatal'])->default('Mild');
                $table->enum('reaction', ['Rash', 'Urticaria', 'Anaphylaxis', 'Angioedema', 'Bronchospasm', 'GI upset', 'Hepatotoxicity', 'Stevens-Johnson', 'Other'])->default('Rash');
                $table->text('reaction_description')->nullable();
                $table->date('onset_date')->nullable();
                $table->text('notes')->nullable();
                $table->enum('status', ['Active', 'Resolved', 'Inactive'])->default('Active');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Diagnoses
        if (!Schema::hasTable('diagnoses')) {
            Schema::create('diagnoses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
                $table->string('icd10_code');
                $table->string('description');
                $table->enum('type', ['Principal', 'Admitting', 'Working', 'Discharge', 'Secondary', 'Comorbidity'])->default('Working');
                $table->enum('status', ['Active', 'Resolved', 'Chronic', 'Recurrent'])->default('Active');
                $table->date('onset_date')->nullable();
                $table->date('resolved_date')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Appointments
        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();
                $table->foreignId('provider_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('appointment_number')->unique();
                $table->date('appointment_date');
                $table->time('appointment_time');
                $table->integer('estimated_duration')->default(30);
                $table->enum('visit_type', ['New', 'Follow-up', 'Review', 'Telemedicine']);
                $table->enum('priority', ['Routine', 'Urgent', 'Emergency'])->default('Routine');
                $table->text('reason_for_visit');
                $table->enum('status', ['Scheduled', 'Confirmed', 'Checked In', 'Completed', 'Cancelled', 'No Show'])->default('Scheduled');
                $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
                $table->text('notes')->nullable();
                $table->text('cancellation_reason')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Prescriptions
        if (!Schema::hasTable('prescriptions')) {
            Schema::create('prescriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('prescriber_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('dispensing_point_id')->nullable()->constrained()->nullOnDelete();
                $table->string('prescription_number')->unique();
                $table->dateTime('prescribed_at');
                $table->dateTime('dispensed_at')->nullable();
                $table->foreignId('dispensed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->enum('status', ['Pending', 'Partially Dispensed', 'Dispensed', 'Cancelled', 'Rejected'])->default('Pending');
                $table->enum('priority', ['Routine', 'Urgent', 'STAT'])->default('Routine');
                $table->boolean('is_inpatient')->default(false);
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Lab Orders
        if (!Schema::hasTable('lab_orders')) {
            Schema::create('lab_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
                $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
                $table->string('order_number')->unique();
                $table->dateTime('ordered_at');
                $table->dateTime('collected_at')->nullable();
                $table->dateTime('resulted_at')->nullable();
                $table->enum('priority', ['Routine', 'Urgent', 'STAT', 'ASAP'])->default('Routine');
                $table->enum('status', ['Pending', 'Sample Collected', 'In Progress', 'Completed', 'Verified', 'Cancelled', 'Rejected'])->default('Pending');
                $table->text('clinical_notes')->nullable();
                $table->text('specimen_source')->nullable();
                $table->string('fasting_status')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Radiology Orders
        if (!Schema::hasTable('radiology_orders')) {
            Schema::create('radiology_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('modality_id')->constrained('radiology_modalities')->cascadeOnDelete();
                $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
                $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
                $table->string('order_number')->unique();
                $table->dateTime('ordered_at');
                $table->dateTime('performed_at')->nullable();
                $table->dateTime('resulted_at')->nullable();
                $table->string('examination');
                $table->string('body_part')->nullable();
                $table->text('clinical_indication')->nullable();
                $table->text('request_notes')->nullable();
                $table->enum('priority', ['Routine', 'Urgent', 'STAT'])->default('Routine');
                $table->enum('status', ['Pending', 'Scheduled', 'In Progress', 'Completed', 'Verified', 'Cancelled'])->default('Pending');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Stock Movements (for pharmacy)
        if (!Schema::hasTable('stock_movements')) {
            Schema::create('stock_movements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
                $table->foreignId('drug_batch_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('dispensing_point_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->enum('type', ['Receipt', 'Transfer In', 'Transfer Out', 'Dispense', 'Adjustment In', 'Adjustment Out', 'Return', 'Disposal', 'Stock Take']);
                $table->string('reference_number')->nullable();
                $table->dateTime('movement_date');
                $table->decimal('quantity', 12, 2)->default(0);
                $table->decimal('balance_after', 12, 2)->default(0);
                $table->text('reason')->nullable();
                $table->timestamps();
            });
        }

        // States (if not exists)
        if (!Schema::hasTable('states')) {
            Schema::create('states', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('code')->unique();
                $table->timestamps();
            });
        }

        // Locals (LGAs)
        if (!Schema::hasTable('locals')) {
            Schema::create('locals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('state_id')->constrained()->cascadeOnDelete();
                $table->string('local_name');
                $table->timestamps();
            });
        }

        // Purchases
        if (!Schema::hasTable('purchases')) {
            Schema::create('purchases', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('received_by')->constrained('users')->cascadeOnDelete();
                $table->string('purchase_number')->unique();
                $table->string('invoice_number')->nullable();
                $table->string('lpo_number')->nullable();
                $table->date('order_date');
                $table->date('received_date')->nullable();
                $table->date('invoice_date')->nullable();
                $table->decimal('subtotal', 14, 2)->default(0);
                $table->decimal('tax_amount', 14, 2)->default(0);
                $table->decimal('discount_amount', 14, 2)->default(0);
                $table->decimal('total_amount', 14, 2)->default(0);
                $table->decimal('amount_paid', 14, 2)->default(0);
                $table->enum('status', ['Draft', 'Ordered', 'Partially Received', 'Received', 'Cancelled'])->default('Draft');
                $table->enum('payment_status', ['Unpaid', 'Partially Paid', 'Paid'])->default('Unpaid');
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Receipts (for purchases)
        if (!Schema::hasTable('receipts')) {
            Schema::create('receipts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
                $table->foreignId('purchase_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('received_by')->constrained('users')->cascadeOnDelete();
                $table->string('receipt_number')->unique();
                $table->date('received_date');
                $table->string('invoice_number')->nullable();
                $table->string('delivery_note_number')->nullable();
                $table->text('notes')->nullable();
                $table->enum('status', ['Pending', 'Verified', 'Rejected'])->default('Pending');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void {
        // Don't drop - these are essential tables
    }
};
