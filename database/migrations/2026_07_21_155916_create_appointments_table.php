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
       Schema::create('appointments', function (Blueprint $table) {

                        $table->id();

                        $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();

                        $table->foreignId('patient_id')->constrained()->cascadeOnDelete();

                        $table->foreignId('clinic_id')->constrained()->cascadeOnDelete();

                        $table->foreignId('provider_id')
                                ->nullable()
                                ->constrained('users')
                                ->nullOnDelete();

                        $table->string('appointment_number')->unique();

                        $table->date('appointment_date');

                        $table->time('appointment_time');

                        $table->unsignedInteger('estimated_duration')->default(30);

                        $table->enum('visit_type', [
                                'New',
                                'Follow-up',
                                'Review',
                                'Telemedicine',
                        ]);

                        $table->enum('priority', [
                                'Routine',
                                'Urgent',
                                'Emergency',
                        ])->default('Routine');

                        $table->text('reason_for_visit');

                        $table->enum('status', [
                                'Scheduled',
                                'Confirmed',
                                'Checked In',
                                'Completed',
                                'Cancelled',
                                'No Show',
                        ])->default('Scheduled');

                        // Note: encounter_id is nullable + indexed but not FK-constrained
                        // because appointments can precede encounters (circular reference).
                        // Encounters.appointment_id is FK-constrained to this table.
                        $table->foreignId('encounter_id')
                                ->nullable()
                                ->index()
                                ->nullOnDelete();

                        $table->foreignId('created_by')
                                ->constrained('users')
                                ->cascadeOnDelete();

                        $table->text('notes')->nullable();

                        $table->text('cancellation_reason')->nullable();

                        $table->timestamps();
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
