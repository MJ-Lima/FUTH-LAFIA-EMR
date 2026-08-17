<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('blood_donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_number')->unique();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('donor_id')->constrained('blood_donors')->cascadeOnDelete();
            $table->date('donation_date');
            $table->time('donation_time');
            $table->enum('donation_type', ['Whole Blood', 'Plasma', 'Platelets', 'Double Red Cells', 'Cryoprecipitate'])->default('Whole Blood');
            $table->decimal('volume_collected_ml', 6, 0)->default(450);
            $table->foreignId('collected_by')->constrained('users')->cascadeOnDelete();
            $table->string('collection_site')->nullable();
            $table->string('vein_used')->nullable();
            $table->text('adverse_reactions')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Collected', 'Screening', 'Quarantined', 'Available', 'Discarded', 'Expired', 'Transfused'])->default('Collected');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['donor_id', 'donation_date']);
        });
    }
    public function down(): void { Schema::dropIfExists('blood_donations'); }
};
