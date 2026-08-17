<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('short_name')->nullable();
            $table->enum('type', ['NHIA', 'HMO', 'Private Insurance', 'Corporate', 'Community-Based', 'Government'])->default('HMO');
            $table->string('nhia_code')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->decimal('capitation_rate', 14, 2)->default(0);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->integer('claim_settlement_days')->default(30);
            $table->string('logo_path')->nullable();
            $table->enum('status', ['Active', 'Suspended', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'status']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_providers');
    }
};
