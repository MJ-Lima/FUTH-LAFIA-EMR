<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('blood_transfusions', function (Blueprint $table) {
            $table->id();
            $table->string('transfusion_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('encounter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('admission_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('blood_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('blood_unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crossmatch_id')->nullable()->constrained('blood_crossmatches')->nullOnDelete();
            $table->foreignId('transfused_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('transfusion_started_at');
            $table->dateTime('transfusion_ended_at')->nullable();
            $table->decimal('volume_transfused_ml', 6, 0)->default(0);
            $table->string('site_of_transfusion')->nullable();
            $table->string('cannula_size')->nullable();
            $table->decimal('pre_transfusion_bp', 8, 0)->nullable();
            $table->decimal('post_transfusion_bp', 8, 0)->nullable();
            $table->decimal('pre_transfusion_temp_c', 4, 1)->nullable();
            $table->decimal('post_transfusion_temp_c', 4, 1)->nullable();
            $table->decimal('pre_transfusion_pulse', 4, 0)->nullable();
            $table->decimal('post_transfusion_pulse', 4, 0)->nullable();
            $table->text('adverse_reactions')->nullable();
            $table->enum('reaction_severity', ['None', 'Mild', 'Moderate', 'Severe', 'Fatal'])->default('None');
            $table->text('action_taken')->nullable();
            $table->enum('status', ['In Progress', 'Completed', 'Interrupted', 'Cancelled'])->default('In Progress');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['patient_id', 'transfusion_started_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('blood_transfusions'); }
};
