<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_insurance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('insurance_provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('insurance_plan_id')->constrained()->cascadeOnDelete();
            $table->string('policy_number')->unique();
            $table->string('member_id')->nullable();
            $table->string('enrollee_code')->nullable();
            $table->enum('principal_relationship', ['Self', 'Spouse', 'Child', 'Parent', 'Sibling', 'Dependant'])->default('Self');
            $table->string('principal_name')->nullable();
            $table->string('principal_dob')->nullable();
            $table->string('principal_phone')->nullable();
            $table->string('principal_nin')->nullable();
            $table->date('enrollment_date');
            $table->date('effective_date');
            $table->date('expiry_date');
            $table->decimal('remaining_benefit', 14, 2)->default(0);
            $table->decimal('utilized_benefit', 14, 2)->default(0);
            $table->boolean('is_primary')->default(true);
            $table->enum('verification_status', ['Pending', 'Verified', 'Rejected', 'Expired'])->default('Pending');
            $table->dateTime('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->enum('status', ['Active', 'Suspended', 'Expired', 'Cancelled'])->default('Active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'status']);
            $table->index(['insurance_provider_id', 'status']);
            $table->index('policy_number');
            $table->index(['effective_date', 'expiry_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_insurance');
    }
};
