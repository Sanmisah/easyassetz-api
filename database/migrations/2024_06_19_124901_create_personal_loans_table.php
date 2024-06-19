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
        Schema::create('personal_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('bank_name')->nullable();
            $table->string('loan_account_no')->nullable();
            $table->string('branch')->nullable();
            $table->string('emi_date')->nullable();
            $table->string('start_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_mobile')->nullable();
            $table->string('guarantor_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_loans');
    }
};
