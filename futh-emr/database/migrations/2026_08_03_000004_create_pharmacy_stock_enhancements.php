<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Goods Received Notes (GRN) — formal receipt of drugs into the pharmacy ----
        Schema::create('goods_received_notes', function (Blueprint $table) {
            $table->id();
            $table->string('grn_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('receipt_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('dispensing_point_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('received_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('received_at');
            $table->string('invoice_number')->nullable();
            $table->string('delivery_note_number')->nullable();
            $table->string('lpo_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->decimal('total_value', 14, 2)->default(0);
            $table->decimal('total_rejected', 14, 2)->default(0);
            $table->enum('status', ['Pending', 'Verified', 'Rejected', 'Posted'])->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'received_at']);
            $table->index('grn_number');
        });

        Schema::create('goods_received_note_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grn_id')->constrained('goods_received_notes')->cascadeOnDelete();
            $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_batch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('drug_name');
            $table->string('batch_number');
            $table->date('expiry_date');
            $table->date('manufactured_date')->nullable();
            $table->decimal('quantity_ordered', 12, 2)->default(0);
            $table->decimal('quantity_received', 12, 2)->default(0);
            $table->decimal('quantity_rejected', 12, 2)->default(0);
            $table->decimal('unit_cost', 14, 2)->default(0);
            $table->decimal('line_total', 14, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['grn_id']);
            $table->index(['drug_id']);
        });

        // ---- Drug Stock Levels (per dispensing point, real-time balance) ----
        Schema::create('drug_stock_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('drug_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dispensing_point_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('quantity_on_hand', 12, 2)->default(0);
            $table->decimal('quantity_reserved', 12, 2)->default(0);
            $table->decimal('quantity_available', 12, 2)->default(0);
            $table->decimal('quantity_in_transit', 12, 2)->default(0);
            $table->decimal('reorder_level', 12, 2)->default(0);
            $table->decimal('reorder_quantity', 12, 2)->default(0);
            $table->date('last_received_date')->nullable();
            $table->date('last_dispensed_date')->nullable();
            $table->date('last_counted_date')->nullable();
            $table->enum('stock_status', ['In Stock', 'Low Stock', 'Out of Stock', 'Over Stock', 'Discontinued'])->default('In Stock');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'stock_status']);
            $table->unique(['drug_id', 'dispensing_point_id'], 'uniq_drug_dispensing_point');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drug_stock_levels');
        Schema::dropIfExists('goods_received_note_items');
        Schema::dropIfExists('goods_received_notes');
    }
};
