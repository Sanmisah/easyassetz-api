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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            // relationship
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('fullLegalName');
            $table->string('relationship');
            $table->string('gender');
            $table->string('dob');
            
            // guardian details 
            $table->string('guardianFullLegalName')->nullable();
            $table->string('guardianMobileNumber');
            $table->string('guardianEmail')->nullable();
            $table->string('guardianCity');
            $table->string('guardianState');

            // optional info
            $table->string('adharNumber')->nullable();
            $table->string('panNumber')->nullable();
            $table->string('passportNumber')->nullable();
            $table->string('drivingLicenceNumber')->nullable();
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();

            // address information
            $table->string('houseFlatNo');
            $table->longText('addressLine1');
            $table->longText('addressLine2')->nullable();
            $table->string('pincode');
            $table->string('beneficiaryCity');
            $table->string('beneficiaryState')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
