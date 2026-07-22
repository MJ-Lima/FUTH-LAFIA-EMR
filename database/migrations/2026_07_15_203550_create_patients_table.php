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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
			$table->string('patientcode', length: 200)->unique();
			$table->integer('hospital_id')->nullable();
			$table->string('firstname', length: 200);
			$table->string('middlename', length: 200);
			$table->string('lastname', length: 200);
			$table->date('dob');
			$table->string('gender', length: 7);
			$table->string('bloodgroup', length: 7)->nullable();
			$table->string('genotype', length: 2)->nullable();
			$table->string('marital', length: 20)->nullable();
			$table->string('religion', length: 200)->nullable();
			$table->string('occupation', length: 255)->nullable();
			$table->string('phonemain', length: 13);
			$table->string('phonealt', length: 13)->nullable();
			$table->string('email', length: 250)->nullable();
			$table->text('address');
			$table->string('city', length: 250);
			$table->string('state', length: 250);
			$table->string('country', length: 250);
			$table->string('postalcode', length: 12)->nullable();
			$table->string('nokname', length: 250);
			$table->string('relationship', length: 250);
			$table->string('nokphone', length: 250);
			$table->text('nokaddress');
			$table->string('hereabout', length: 250)->nullable();
			$table->string('notes', length: 250)->nullable();
			$table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
