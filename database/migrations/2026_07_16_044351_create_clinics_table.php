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
        Schema::create('clinics', function (Blueprint $table) {

			$table->id();

			$table->foreignId('hospital_id')
				->constrained()
				->cascadeOnDelete();

			$table->string('name');

			$table->string('code')->nullable();

			$table->boolean('status')->default(true);

			$table->timestamps();
			$table->softDeletes();
			$table->unique(['hospital_id', 'code']);
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
