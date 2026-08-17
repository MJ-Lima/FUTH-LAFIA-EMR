<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('blood_donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('donor_number')->unique();
            $table->enum('donor_type', ['Voluntary', 'Replacement', 'Autologous', 'Directed', 'Paid'])->default('Voluntary');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->enum('gender', ['Male', 'Female']);
            $table->date('date_of_birth');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->enum('rh_factor', ['Positive', 'Negative']);
            $table->date('last_donation_date')->nullable();
            $table->integer('total_donations')->default(0);
            $table->decimal('total_volume_donated_ml', 8, 0)->default(0);
            $table->boolean('is_eligible')->default(true);
            $table->text('ineligibility_reason')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Deferred', 'Blacklisted'])->default('Active');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['hospital_id', 'status']);
            $table->index(['blood_group', 'rh_factor']);
        });
    }
    public function down(): void { Schema::dropIfExists('blood_donors'); }
};
