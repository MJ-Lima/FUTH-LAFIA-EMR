<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Store Categories ----
        Schema::create('store_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['Medical Supplies', 'Office Supplies', 'Cleaning', 'Furniture', 'Equipment', 'IT', 'Kitchen', 'Linens', 'Fuel & Lubricants', 'Stationery', 'PPE', 'Other'])->default('Medical Supplies');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'type']);
        });

        // ---- Store Locations (where items are kept) ----
        Schema::create('store_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['Main Store', 'Sub-Store', 'Pharmacy Store', 'Theatre Store', 'Lab Store', 'Ward Store', 'Emergency Store', 'Other'])->default('Main Store');
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->foreignId('in_charge_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'type']);
        });

        // ---- Store Items (master list of non-drug items) ----
        Schema::create('store_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_category_id')->nullable()->constrained()->nullOnDelete();
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

            $table->index(['hospital_id', 'store_category_id']);
            $table->index('code');
        });

        // ---- Store Stocks (per location, per item, per batch) ----
        Schema::create('store_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_location_id')->constrained()->cascadeOnDelete();
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

            $table->index(['store_item_id', 'store_location_id']);
            $table->index(['store_location_id', 'quantity_remaining']);
            $table->index('expiry_date');
        });

        // ---- Store Movements ----
        Schema::create('store_movements', function (Blueprint $table) {
            $table->id();
            $table->string('movement_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_stock_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('from_location_id')->nullable()->constrained('store_locations')->nullOnDelete();
            $table->foreignId('to_location_id')->nullable()->constrained('store_locations')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['Receipt', 'Transfer In', 'Transfer Out', 'Issue', 'Return', 'Adjustment In', 'Adjustment Out', 'Disposal', 'Stock Take'])->default('Issue');
            $table->string('reference_number')->nullable();
            $table->string('reference_type')->nullable(); // Requisition, Issue Voucher, GRN, etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->dateTime('movement_date');
            $table->decimal('quantity', 14, 2)->default(0);
            $table->decimal('balance_after', 14, 2)->default(0);
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['store_item_id', 'movement_date']);
            $table->index(['from_location_id', 'to_location_id']);
        });

        // ---- Store Requisitions (department asks main store for items) ----
        Schema::create('store_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requesting_department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('requesting_location_id')->nullable()->constrained('store_locations')->nullOnDelete();
            $table->foreignId('source_location_id')->nullable()->constrained('store_locations')->nullOnDelete();
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
            $table->index('requisition_number');
        });

        Schema::create('store_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_requisition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_item_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity_requested', 14, 2)->default(0);
            $table->decimal('quantity_approved', 14, 2)->default(0);
            $table->decimal('quantity_issued', 14, 2)->default(0);
            $table->decimal('unit_cost', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['store_requisition_id']);
        });

        // ---- Stock Takes ----
        Schema::create('stock_takes', function (Blueprint $table) {
            $table->id();
            $table->string('stock_take_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained('store_locations')->nullOnDelete();
            $table->enum('scope', ['Full Hospital', 'Single Location', 'Pharmacy', 'Specific Items'])->default('Full Hospital');
            $table->date('stock_take_date');
            $table->foreignId('initiated_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('counted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['Planned', 'In Progress', 'Counted', 'Verified', 'Closed', 'Cancelled'])->default('Planned');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('stock_take_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_take_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('drug_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_name');
            $table->string('batch_number')->nullable();
            $table->decimal('system_quantity', 14, 2)->default(0);
            $table->decimal('counted_quantity', 14, 2)->default(0);
            $table->decimal('variance', 14, 2)->default(0);
            $table->decimal('unit_cost', 14, 2)->default(0);
            $table->decimal('variance_value', 14, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['stock_take_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_take_items');
        Schema::dropIfExists('stock_takes');
        Schema::dropIfExists('store_requisition_items');
        Schema::dropIfExists('store_requisitions');
        Schema::dropIfExists('store_movements');
        Schema::dropIfExists('store_stocks');
        Schema::dropIfExists('store_items');
        Schema::dropIfExists('store_locations');
        Schema::dropIfExists('store_categories');
    }
};
