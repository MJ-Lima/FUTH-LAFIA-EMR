<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('insurance_claim_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('payer_type', ['Patient', 'Insurance', 'NHIA', 'Corporate', 'Government', 'Other'])->default('Patient');
            $table->string('payer_name')->nullable();
            $table->enum('payment_method', ['Cash', 'Card', 'Bank Transfer', 'Cheque', 'Mobile Money', 'POS', 'Insurance', 'Online'])->default('Cash');
            $table->decimal('amount', 14, 2)->default(0);
            $table->string('currency', 3)->default('NGN');
            $table->string('reference_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->dateTime('payment_date');
            $table->foreignId('received_by')->constrained('users')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->enum('status', ['Pending', 'Completed', 'Reversed', 'Bounced'])->default('Completed');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'status']);
            $table->index(['patient_id', 'status']);
            $table->index(['invoice_id']);
            $table->index('payment_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
