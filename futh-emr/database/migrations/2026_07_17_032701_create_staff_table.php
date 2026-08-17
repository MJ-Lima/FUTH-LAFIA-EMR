<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('hospital_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('clinic_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('staff_number')->unique();

            $table->string('title')->nullable();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->enum('gender', [
                'Male',
                'Female'
            ]);

            $table->date('date_of_birth')->nullable();

            $table->string('phone')->nullable();

            $table->text('address')->nullable();

            $table->string('designation')->nullable();

            $table->enum('staff_type', [
                'Doctor',
                'Nurse',
                'Pharmacist',
                'Laboratory Scientist',
                'Radiographer',
                'Physiotherapist',
                'Administrator',
                'Accountant',
                'ICT',
                'Medical Records',
                'Other'
            ]);

            $table->string('passport')->nullable();

            $table->string('signature')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->softDeletes();

            $table->index('staff_number');
            $table->index('last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
