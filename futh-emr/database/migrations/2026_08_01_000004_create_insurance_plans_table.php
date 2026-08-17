<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_provider_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('tier', ['Formal', 'Informal', 'Equity', 'Vulnerable', 'Premium', 'Standard', 'VIP'])->default('Standard');
            $table->enum('coverage_type', ['Individual', 'Family', 'Corporate', 'Group'])->default('Individual');
            $table->decimal('annual_premium', 14, 2)->default(0);
            $table->decimal('annual_benefit_limit', 14, 2)->default(0);
            $table->decimal('per_encounter_limit', 14, 2)->default(0);
            $table->decimal('outpatient_deduction', 14, 2)->default(0);
            $table->decimal('inpatient_deduction', 14, 2)->default(0);
            $table->decimal('copay_percentage', 5, 2)->default(0);
            $table->json('covered_services')->nullable();
            $table->json('excluded_services')->nullable();
            $table->boolean('covers_pharmacy')->default(true);
            $table->boolean('covers_lab')->default(true);
            $table->boolean('covers_radiology')->default(true);
            $table->boolean('covers_inpatient')->default(false);
            $table->boolean('covers_maternity')->default(false);
            $table->boolean('covers_dental')->default(false);
            $table->boolean('covers_optical')->default(false);
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['insurance_provider_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_plans');
    }
};
