<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- General Store Locations ----
        Schema::create('general_store_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['Main Store', 'Sub-Store', 'Ward Store', 'Department Store', 'Theatre Store', 'Emergency Store', 'Other'])->default('Main Store');
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->foreignId('in_charge_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'type']);
        });

        // ---- General Store Categories ----
        Schema::create('general_store_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['Medical Supplies', 'Office Supplies', 'Cleaning', 'Furniture', 'Equipment', 'IT', 'Kitchen', 'Linens', 'Fuel & Lubricants', 'Stationery', 'PPE', 'Surgical Consumables', 'Lab Consumables', 'Other'])->default('Medical Supplies');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'type']);
        });

        // ---- General Store Items ----
        Schema::create('general_store_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('general_store_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('barcode')->nullable();
            $table->string('generic_name')->nullable();
            $table->string('brand')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('supplier')->nullable();
            $table->string('unit_of_measure');
            $table->string('pack_size')->nullable();
            $table->integer('units_per_pack')->default(1);
            $table->decimal('cost_price', 14, 2)->default(0);
            $table->decimal('selling_price', 14, 2)->default(0);
            $table->decimal('reorder_level', 14, 2)->default(0);
            $table->decimal('reorder_quantity', 14, 2)->default(0);
            $table->boolean('is_consumable')->default(true);
            $table->boolean('is_reusable')->default(false);
            $table->boolean('requires_cold_chain')->default(false);
            $table->boolean('is_controlled')->default(false);
            $table->boolean('tracks_expiry')->default(false);
            $table->boolean('tracks_serial')->default(false);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'general_store_category_id']);
            $table->index('code');
        });

        // ---- General Store Stock (per location, per item, per batch) ----
        Schema::create('general_store_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('general_store_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('general_store_location_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('quantity_received', 14, 2)->default(0);
            $table->decimal('quantity_remaining', 14, 2)->default(0);
            $table->decimal('unit_cost', 14, 2)->default(0);
            $table->date('received_date')->nullable();
            $table->string('reference_number')->nullable();
            $table->boolean('is_quarantined')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['general_store_item_id', 'general_store_location_id']);
            $table->index('expiry_date');
        });

        // ---- General Store Movements ----
        Schema::create('general_store_movements', function (Blueprint $table) {
            $table->id();
            $table->string('movement_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('general_store_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('general_store_stock_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('from_location_id')->nullable()->constrained('general_store_locations')->nullOnDelete();
            $table->foreignId('to_location_id')->nullable()->constrained('general_store_locations')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['Receipt', 'Transfer In', 'Transfer Out', 'Issue', 'Return', 'Adjustment In', 'Adjustment Out', 'Disposal', 'Stock Take'])->default('Issue');
            $table->string('reference_number')->nullable();
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->dateTime('movement_date');
            $table->decimal('quantity', 14, 2)->default(0);
            $table->decimal('balance_after', 14, 2)->default(0);
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['general_store_item_id', 'movement_date']);
        });

        // ---- General Store Requisitions ----
        Schema::create('general_store_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requesting_department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('requesting_location_id')->nullable()->constrained('general_store_locations')->nullOnDelete();
            $table->foreignId('source_location_id')->nullable()->constrained('general_store_locations')->nullOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('required_date');
            $table->date('approved_date')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('received_date')->nullable();
            $table->enum('priority', ['Routine', 'Urgent', 'Emergency'])->default('Routine');
            $table->text('purpose')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Draft', 'Pending', 'Approved', 'Partially Issued', 'Issued', 'Received', 'Rejected', 'Cancelled'])->default('Draft');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['requesting_department_id', 'status']);
        });

        Schema::create('general_store_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_store_requisition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('general_store_item_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity_requested', 14, 2)->default(0);
            $table->decimal('quantity_approved', 14, 2)->default(0);
            $table->decimal('quantity_issued', 14, 2)->default(0);
            $table->decimal('unit_cost', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['general_store_requisition_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_store_requisition_items');
        Schema::dropIfExists('general_store_requisitions');
        Schema::dropIfExists('general_store_movements');
        Schema::dropIfExists('general_store_stocks');
        Schema::dropIfExists('general_store_items');
        Schema::dropIfExists('general_store_categories');
        Schema::dropIfExists('general_store_locations');
    }
};
