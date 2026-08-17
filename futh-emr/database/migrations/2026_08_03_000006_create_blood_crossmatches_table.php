<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('blood_crossmatches', function (Blueprint $table) {
            $table->id();
            $table->string('crossmatch_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('blood_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('blood_unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('performed_by')->constrained('users')->cascadeOnDelete();
            $table->enum('method', ['Saline', 'Albumin', 'AHG', 'Gel Card', 'Electronic Crossmatch'])->default('Saline');
            $table->enum('major_crossmatch', ['Compatible', 'Incompatible', 'Pending'])->default('Pending');
            $table->enum('minor_crossmatch', ['Compatible', 'Incompatible', 'Not Done', 'Pending'])->default('Not Done');
            $table->text('results')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('performed_at');
            $table->enum('status', ['Pending', 'Compatible', 'Incompatible', 'Expired', 'Transfused', 'Discarded'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['blood_request_id', 'status']);
            $table->index(['blood_unit_id', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('blood_crossmatches'); }
};
