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
        Schema::create('charities', function (Blueprint $table) {
            $table->id();
            
            // relationship
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->text('organizationName');
            $table->longText('address1')->nullable();
            $table->longText('address2')->nullable();
            $table->string('charityCity');
            $table->string('state')->nullable();
            $table->string('phoneNumber');
            $table->string('email')->nullable();
            $table->string('contactPerson');
            $table->text('website')->nullable();
            $table->longText('specificInstruction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charities');
    }
};
