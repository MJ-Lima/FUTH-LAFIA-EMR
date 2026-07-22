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
        Schema::create('encounters', function (Blueprint $table) {
            $table->id();
			$table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
			$table->foreignId('patient_id')->constrained()->cascadeOnDelete();
			$table->foreignId('clinic_id')->constrained()->cascadeOnDelete();

			$table->foreignId('user_id')
				->nullable()
				->constrained('users')
				->nullOnDelete();

			$table->string('encounter_number')->unique();

			$table->enum('visit_type', [
				'Outpatient',
				'Emergency',
				'Inpatient',
				'Telemedicine',
				'Follow-up'
			]);

			$table->date('encounter_date');

			$table->time('encounter_time');

			$table->enum('status', [
				'Waiting',
				'In Progress',
				'Completed',
				'Cancelled'
			])->default('Waiting');

			$table->text('chief_complaint')->nullable();

			$table->string('referred_by')->nullable();

			$table->foreignId('appointment_id')
				->nullable()
				->constrained()
				->nullOnDelete();

			$table->foreignId('created_by')
				->constrained('users')
				->cascadeOnDelete();

			$table->text('notes')->nullable();
					$table->timestamps();
				});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};
