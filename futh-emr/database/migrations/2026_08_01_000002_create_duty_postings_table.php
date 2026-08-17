<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('duty_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duty_roster_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('clinic_id')->nullable()->constrained()->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('shift', ['Morning', 'Afternoon', 'Night', 'On-Call', 'Full Day'])->default('Morning');
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->enum('role_in_unit', ['In-Charge', 'Supervisor', 'Officer', 'Assistant', 'Trainee'])->default('Officer');
            $table->text('notes')->nullable();
            $table->enum('status', ['Scheduled', 'Active', 'Completed', 'Cancelled', 'Swapped'])->default('Scheduled');
            $table->foreignId('posted_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'start_date', 'end_date']);
            $table->index(['hospital_id', 'department_id', 'clinic_id']);
            $table->index(['status', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duty_postings');
    }
};
