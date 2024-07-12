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
        Schema::create('commercial_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('property_type')->nullable();
            $table->string('house_number')->nullable();
            $table->string('address_1')->nullable();
            $table->string('pincode')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('property_status')->nullable();
            $table->string('ownership_by_virtue_of')->nullable();
            $table->string('ownership_type')->nullable();
            $table->string('first_holders_name')->nullable();
            $table->string('first_holders_relation')->nullable();
            $table->string('first_holders_aadhar')->nullable();
            $table->string('first_holders_pan')->nullable();
            $table->string('joint_holders_name')->nullable();
            $table->string('joint_holders_relation')->nullable();
            $table->string('joint_holders_pan')->nullable();
            $table->string('any_loan_litigation')->nullable();
            $table->string('litigation_file')->nullable();
            $table->string('agreement_copy')->nullable();
            $table->string('rent_agreement_file')->nullable();
            $table->string('share_certificate_file')->nullable();
            $table->string('lease_document_file')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_properties');
    }
};
