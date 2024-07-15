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
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('property_type')->nullable();
            $table->string('survey_number')->nullable();
            $table->string('address')->nullable();
            $table->string('village_name')->nullable();
            $table->string('district')->nullable();
            $table->string('taluka')->nullable();
            $table->string('ownership_by_virtue_of')->nullable();
            $table->enum('ownership_type',['single','joint'])->nullable();
            $table->string('first_holders_name')->nullable();
            $table->string('first_holders_relation')->nullable();
            $table->string('first_holders_pan')->nullable();
            $table->string('first_holders_aadhar')->nullable();
            $table->string('joint_holders_name')->nullable();
            $table->string('joint_holders_relation')->nullable();
            $table->string('joint_holders_pan')->nullable();
            $table->string('joint_holders_aadhar')->nullable();
            $table->string('any_loan_litigation')->nullable();
            $table->string('litigation_file')->nullable();
            $table->string('lease_document_file')->nullable();
            $table->string('agreement_file')->nullable();
            $table->string('extract_7_12')->nullable();
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
        Schema::dropIfExists('lands');
    }
};
