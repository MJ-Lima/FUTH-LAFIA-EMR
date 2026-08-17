<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('default_clinic_id')->nullable()->after('department_id')->constrained('clinics')->nullOnDelete();
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('avatar_url')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['default_clinic_id']);
            $table->dropColumn(['default_clinic_id', 'phone', 'avatar_url']);
        });
    }
};
