<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ---- Chart of Accounts ----
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('account_code', 30)->unique();
            $table->string('name');
            $table->enum('type', ['Asset', 'Liability', 'Equity', 'Revenue', 'Expense', 'Contra'])->default('Asset');
            $table->enum('sub_type', [
                'Current Asset', 'Fixed Asset', 'Other Asset',
                'Current Liability', 'Long-term Liability', 'Other Liability',
                'Capital', 'Retained Earnings',
                'Operating Revenue', 'Other Revenue',
                'Operating Expense', 'Administrative Expense', 'Cost of Goods Sold', 'Other Expense',
                'Contra Asset', 'Contra Revenue',
            ])->default('Current Asset');
            $table->string('currency', 3)->default('NGN');
            $table->foreignId('parent_account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->decimal('opening_balance', 18, 2)->default(0);
            $table->decimal('current_balance', 18, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_bank_account')->default(false);
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'type']);
            $table->index('account_code');
        });

        // ---- Journal Entries ----
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('entry_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->date('entry_date');
            $table->enum('type', ['Sales', 'Purchase', 'Payment', 'Receipt', 'Journal', 'Payroll', 'Adjustment', 'Closing', 'Reversal'])->default('Journal');
            $table->string('reference_number')->nullable();
            $table->string('reference_type')->nullable(); // Invoice, Payment, Claim, etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('description');
            $table->decimal('total_debit', 18, 2)->default(0);
            $table->decimal('total_credit', 18, 2)->default(0);
            $table->boolean('is_posted')->default(false);
            $table->boolean('is_reversed')->default(false);
            $table->dateTime('posted_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'entry_date']);
            $table->index('entry_number');
            $table->index(['reference_type', 'reference_id']);
        });

        // ---- Journal Lines ----
        Schema::create('journal_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_entry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chart_of_account_id')->constrained()->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->decimal('debit', 18, 2)->default(0);
            $table->decimal('credit', 18, 2)->default(0);
            $table->string('cost_center')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            $table->timestamps();

            $table->index(['journal_entry_id']);
            $table->index(['chart_of_account_id']);
        });

        // ---- Budgets ----
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('chart_of_account_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('period', ['Monthly', 'Quarterly', 'Annual'])->default('Annual');
            $table->year('fiscal_year');
            $table->integer('quarter')->nullable();
            $table->integer('month')->nullable();
            $table->decimal('planned_amount', 18, 2)->default(0);
            $table->decimal('actual_amount', 18, 2)->default(0);
            $table->decimal('variance', 18, 2)->default(0);
            $table->enum('status', ['Draft', 'Approved', 'Active', 'Closed', 'Revised'])->default('Draft');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'fiscal_year']);
            $table->index(['department_id']);
        });

        // ---- Expense Claims ----
        Schema::create('expense_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('claimant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->enum('type', ['Travel', 'Medical Supplies', 'Office Supplies', 'Maintenance', 'Utility', 'Transport', 'Meals', 'Training', 'Other'])->default('Other');
            $table->date('expense_date');
            $table->decimal('total_amount', 18, 2)->default(0);
            $table->decimal('reimbursable_amount', 18, 2)->default(0);
            $table->decimal('approved_amount', 18, 2)->default(0);
            $table->string('currency', 3)->default('NGN');
            $table->text('description')->nullable();
            $table->json('receipts')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected', 'Paid', 'Cancelled'])->default('Draft');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('reviewed_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->text('review_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'status']);
            $table->index(['claimant_id', 'status']);
        });

        // ---- Petty Cash ----
        Schema::create('petty_cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('dispensing_point_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['Top Up', 'Expense', 'Reimbursement', 'Adjustment'])->default('Expense');
            $table->dateTime('transaction_date');
            $table->decimal('amount', 18, 2)->default(0);
            $table->decimal('balance_after', 18, 2)->default(0);
            $table->string('payee')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Posted'])->default('Pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['hospital_id', 'transaction_date']);
            $table->index('voucher_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petty_cash_transactions');
        Schema::dropIfExists('expense_claims');
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('journal_lines');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('chart_of_accounts');
    }
};
