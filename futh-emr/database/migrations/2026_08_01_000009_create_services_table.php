<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category', ['Consultation', 'Procedure', 'Laboratory', 'Radiology', 'Pharmacy', 'Accommodation', 'Consumable', 'Equipment', 'Emergency', 'Other'])->default('Consultation');
            $table->enum('sub_category', ['General', 'Specialist', 'Surgery', 'Dental', 'Optical', 'Mental Health', 'Maternity', 'Physiotherapy'])->default('General');
            $table->string('nhia_code')->nullable();
            $table->decimal('standard_price', 14, 2)->default(0);
            $table->decimal('nhia_rate', 14, 2)->default(0);
            $table->decimal('private_rate', 14, 2)->default(0);
            $table->decimal('cost_price', 14, 2)->default(0);
            $table->string('unit_of_measure')->nullable();
            $table->boolean('is_taxable')->default(false);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('requires_pre_authorization')->default(false);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'category', 'status']);
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
