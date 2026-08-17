<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('service_type', ['Consultation', 'Procedure', 'Laboratory', 'Radiology', 'Pharmacy', 'Accommodation', 'Consumable', 'Other'])->default('Consultation');
            $table->string('description');
            $table->string('reference_number')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 14, 2)->default(0);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discount_amount', 14, 2)->default(0);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('tax_amount', 14, 2)->default(0);
            $table->decimal('insurance_covered', 14, 2)->default(0);
            $table->decimal('patient_portion', 14, 2)->default(0);
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['invoice_id']);
            $table->index('service_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
