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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('full_legal_name');
            $table->string('gender');   
            $table->string('dob');
            $table->string('nationality');  
            $table->string('country_of_residence');
            $table->string('religion');        
            $table->string('marital_status')->nullable();  
            $table->string('married_under_special_act')->default('No');
            $table->string('correspondence_email')->unique();
            $table->string('permanent_house_flat_no');
            $table->longText('permanent_address_line_1');
            $table->longText('permanent_address_line_2')->nullable();
            $table->string('permanent_pincode');
            $table->string('permanent_city');
            $table->string('permanent_state')->nullable();
            $table->string('permanent_country')->nullable();
            $table->string('current_house_flat_no');
            $table->longtext('current_address_line_1');
            $table->longtext('current_address_line_2')->nullable();
            $table->string('current_pincode');
            $table->string('current_city');
            $table->string('current_state')->nullable();
            $table->string('current_country')->nullable();
            $table->string('adhar_number')->nullable();
            $table->string('adhar_name')->nullable();
            $table->string('adhar_file')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('pan_name')->nullable();
            $table->string('pan_file')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_name')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('passport_place_of_issue')->nullable();
            $table->string('passport_file')->nullable();
            $table->string('driving_licence_number')->nullable();
            $table->string('driving_licence_name')->nullable();
            $table->date('driving_licence_expiry_date')->nullable();
            $table->string('driving_licence_place_of_issue')->nullable();
            $table->string('driving_licence_file')->nullable();
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
