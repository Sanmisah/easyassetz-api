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
        Schema::create('business_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('firm_name')->nullable();
            $table->string('registered_address')->nullable();
            $table->string('firm_no_type')->nullable();
            $table->string('firms_registration_number')->nullable();
            $table->string('holding_percentage')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('my_status')->nullable();
            $table->string('type_of_investment')->nullable();
            $table->enum('holding_type',['single','joint'])->nullable();
            $table->json('document_availability')->nullable();
            $table->string('share_centificate_file')->nullable();
            $table->string('partnership_deed_file')->nullable();
            $table->string('jv_agreement_file')->nullable();
            $table->string('loan_deposite_receipt')->nullable();
            $table->string('promisory_note')->nullable();
            $table->string('type_of_ip')->nullable();
            $table->date('expiry_date')->nullable();
            $table->enum('whether_assigned',['yes','no'])->nullable();
            $table->string('name_of_assignee')->nullable();
            $table->date('date_of_assignment')->nullable();
            $table->string('additional_information')->nullable();
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
        Schema::dropIfExists('business_assets');
    }
};
