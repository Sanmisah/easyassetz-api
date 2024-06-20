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
        Schema::create('litigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('litigation_type')->nullable();
            $table->string('court_name')->nullable();
            $table->string('city')->nullable();
            $table->string('case_registration_number')->nullable();
            $table->string('my_status')->nullable();
            $table->string('other_party_name')->nullable();
            $table->string('other_party_address')->nullable();
            $table->string('lawyer_name')->nullable();
            $table->string('lawyer_contact')->nullable();
            $table->date('case_filling_date')->nullable();
            $table->string('status')->nullable();
            $table->string('image')->nullable();
            $table->string('additional_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('litigations');
    }
};
