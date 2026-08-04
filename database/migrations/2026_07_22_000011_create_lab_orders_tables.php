<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Lab Orders + line items + results.
 * HL7 FHIR DiagnosticReport + Observation inspired.
 */
return new class extends Migration
{
    public function up(): void
    {
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
            $table->enum('status', [
                'Pending',
                'Sample Collected',
                'In Progress',
                'Completed',
                'Verified',
                'Cancelled',
                'Rejected',
            ])->default('Pending');

            $table->text('clinical_notes')->nullable();
            $table->text('specimen_source')->nullable();
            $table->string('fasting_status', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['patient_id', 'ordered_at']);
            $table->index('status');
        });

        Schema::create('lab_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lab_test_id')->constrained()->cascadeOnDelete();
            $table->string('test_name')->comment('Snapshot of test name at order time');
            $table->string('loinc_code', 20)->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->enum('status', [
                'Pending',
                'Collected',
                'In Progress',
                'Completed',
                'Verified',
                'Cancelled',
            ])->default('Pending');
            $table->timestamps();
        });

        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_order_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lab_test_id')->constrained()->cascadeOnDelete();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('value')->nullable();
            $table->string('value_numeric')->nullable()->comment('Numeric representation for charting');
            $table->string('unit')->nullable();
            $table->string('reference_range')->nullable();
            $table->enum('flag', ['Normal', 'Low', 'High', 'Critical Low', 'Critical High', 'Abnormal'])->default('Normal');
            $table->text('interpretation')->nullable();
            $table->text('comments')->nullable();

            $table->dateTime('performed_at')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_results');
        Schema::dropIfExists('lab_order_items');
        Schema::dropIfExists('lab_orders');
    }
};
