<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pharmacy master data: drug categories, drugs (ATC-coded), drug batches,
 * and drug-drug interactions. WHO Essential Medicines List aligned.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drug_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 30)->unique()->comment('ATC level-1/2 group code');
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name');
            $table->string('generic_name')->nullable()->comment('INN — International Nonproprietary Name');
            $table->string('code')->unique()->comment('Internal item code');
            $table->string('atc_code', 20)->nullable()->index()->comment('WHO ATC classification code');
            $table->string('dosage_form')->nullable()->comment('Tablet, Capsule, Syrup, Injection, etc.');
            $table->string('strength')->nullable()->comment('e.g. 500mg, 5mg/5mL');
            $table->string('unit_of_measure')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('supplier')->nullable();

            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('selling_price', 12, 2)->default(0);
            $table->decimal('reorder_level', 12, 2)->default(0);
            $table->decimal('reorder_quantity', 12, 2)->default(0);

            $table->boolean('is_controlled')->default(false)->comment('Controlled / narcotic drug');
            $table->boolean('is_antenatal_safe')->default(false);
            $table->boolean('is_pediatric_safe')->default(false);

            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index('name');
            $table->index('generic_name');
        });

        Schema::create('drug_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number');
            $table->date('expiry_date');
            $table->date('manufactured_date')->nullable();
            $table->decimal('quantity_received', 12, 2)->default(0);
            $table->decimal('quantity_remaining', 12, 2)->default(0);
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->string('supplier')->nullable();
            $table->date('received_date')->nullable();
            $table->boolean('is_quarantined')->default(false);
            $table->timestamps();
            $table->index(['drug_id', 'expiry_date']);
        });

        Schema::create('drug_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drug_a_id')->constrained('drugs')->cascadeOnDelete();
            $table->foreignId('drug_b_id')->constrained('drugs')->cascadeOnDelete();

            $table->enum('severity', ['Minor', 'Moderate', 'Major', 'Contraindicated'])->default('Moderate');
            $table->enum('effect', [
                'Additive',
                'Synergistic',
                'Antagonistic',
                'Altered metabolism',
                'Increased toxicity',
                'Decreased efficacy',
                'Other',
            ])->default('Other');

            $table->text('description')->nullable();
            $table->text('clinical_action')->nullable()->comment('Recommended clinical action');
            $table->string('source')->nullable()->comment('Reference — e.g. Stockley, Medscape');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['drug_a_id', 'drug_b_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drug_interactions');
        Schema::dropIfExists('drug_batches');
        Schema::dropIfExists('drugs');
        Schema::dropIfExists('drug_categories');
    }
};
