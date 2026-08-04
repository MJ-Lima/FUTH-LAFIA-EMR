<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pharmacy clinical: prescriptions, prescription items, dispensing logs,
 * stock movements, returns, dispensing points.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Dispensing points (e.g. Main Pharmacy, ANC, Emergency, Paeds, Theatre)
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

            $table->enum('status', [
                'Pending',
                'Partially Dispensed',
                'Dispensed',
                'Cancelled',
                'Rejected',
            ])->default('Pending');

            $table->enum('priority', ['Routine', 'Urgent', 'STAT'])->default('Routine');
            $table->boolean('is_inpatient')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['patient_id', 'prescribed_at']);
        });

        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_batch_id')->nullable()->constrained()->nullOnDelete();

            $table->string('drug_name');
            $table->string('dosage_form')->nullable();
            $table->string('strength')->nullable();

            $table->string('dose')->comment('e.g. 500mg, 1 tablet');
            $table->string('route')->default('PO')->comment('PO, IV, IM, SC, PR, Topical, etc.');
            $table->string('frequency')->comment('BD, TDS, QDS, Q4H, OD, etc.');
            $table->string('duration')->comment('5 days, 2 weeks, etc.');
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('quantity_dispensed')->default(0);

            $table->text('instructions')->nullable();
            $table->enum('status', ['Pending', 'Partially Dispensed', 'Dispensed', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });

        Schema::create('dispensing_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dispensing_point_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('prescription_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('prescription_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_batch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dispensed_by')->constrained('users')->cascadeOnDelete();

            $table->string('reference_number')->unique();
            $table->dateTime('dispensed_at');
            $table->decimal('quantity', 12, 2)->default(0);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('total_price', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'dispensed_at']);
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_batch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('dispensing_point_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->enum('type', [
                'Receipt',
                'Transfer In',
                'Transfer Out',
                'Dispense',
                'Adjustment In',
                'Adjustment Out',
                'Return',
                'Disposal',
                'Stock Take',
            ]);
            $table->string('reference_number')->nullable();
            $table->dateTime('movement_date');
            $table->decimal('quantity', 12, 2)->default(0)->comment('Positive for in, negative for out');
            $table->decimal('balance_after', 12, 2)->default(0);
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->index(['drug_id', 'movement_date']);
        });

        Schema::create('stock_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('dispensing_log_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_batch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('received_by')->constrained('users')->cascadeOnDelete();

            $table->string('return_number')->unique();
            $table->dateTime('returned_at');
            $table->decimal('quantity', 12, 2)->default(0);
            $table->enum('reason', ['Expired', 'Damaged', 'Wrong Dispense', 'Patient Returned', 'Other'])->default('Patient Returned');
            $table->text('notes')->nullable();
            $table->enum('disposition', ['Restocked', 'Quarantined', 'Disposed'])->default('Quarantined');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_returns');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('dispensing_logs');
        Schema::dropIfExists('prescription_items');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('dispensing_points');
    }
};
