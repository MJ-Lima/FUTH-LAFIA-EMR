<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_claim_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_claim_id')->constrained()->cascadeOnDelete();
            $table->enum('service_type', ['Consultation', 'Pharmacy', 'Laboratory', 'Radiology', 'Procedure', 'Consumable', 'Accommodation', 'Other'])->default('Consultation');
            $table->string('service_code')->nullable();
            $table->string('service_name');
            $table->string('item_reference')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 14, 2)->default(0);
            $table->decimal('amount_claimed', 14, 2)->default(0);
            $table->decimal('amount_approved', 14, 2)->default(0);
            $table->decimal('amount_paid', 14, 2)->default(0);
            $table->decimal('patient_copay', 14, 2)->default(0);
            $table->enum('status', ['Pending', 'Approved', 'Partially Approved', 'Rejected'])->default('Pending');
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['insurance_claim_id', 'status']);
            $table->index('service_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_claim_lines');
    }
};
