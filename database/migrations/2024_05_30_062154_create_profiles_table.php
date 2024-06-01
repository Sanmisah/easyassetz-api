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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
                       // foreign key
            $table->foreignId('user_id')->contrained()->onDelete('cascade');
                        // User details
            $table->text('fullLegalName');
            $table->string('gender');   //enum
            $table->string('dob');
            $table->string('nationality');  //enum
            $table->string('countryOfResidence');
            $table->string('religion');        //enum
            $table->string('maritalStatus')->nullable();   //enum
            $table->string('marriedUnderSpecialAct')->default('No');

            // Contact details (permenent address)
            $table->string('correspondenceEmail')->unique();
            $table->string('permanentHouseFlatNo');
            $table->longText('permanentAddressLine1');
            $table->longText('permanentAddressLine2')->nullable();
            $table->string('permanentPincode');
            $table->string('permanentCity');
            $table->string('permanentState')->nullable();
            $table->string('permanentCountry')->nullable();
            //$table->boolean('current_address')->default(false);
      
            // (current address)
            $table->string('currentHouseFlatNo');
            $table->longtext('currentAddressLine1');
            $table->longtext('currentAddressLine2')->nullable();
            $table->string('currentPincode');
            $table->string('currentCity');
            $table->string('currentState')->nullable();
            $table->string('currentCountry')->nullable();


              // KYC details
            //$table->string('identification_details');  //enum
            $table->string('adharNumber')->nullable();
            $table->string('adharName')->nullable();
            $table->string('adharFile')->nullable();
            $table->string('panNumber')->nullable();
            $table->string('panName')->nullable();
            $table->string('panFile')->nullable();
            $table->string('passportNumber')->nullable();
            $table->string('passportName')->nullable();
            $table->date('passportExpiryDate')->nullable();
            $table->string('passportPlaceOfIssue')->nullable();
            $table->string('passportFile')->nullable();
            $table->string('drivingLicenceNumber')->nullable();
            $table->string('drivingLicenceName')->nullable();
            $table->date('drivingLicenceExpiryDate')->nullable();
            $table->string('drivingLicencePlaceOfIssue')->nullable();
            $table->string('drivingLicenceFile')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
