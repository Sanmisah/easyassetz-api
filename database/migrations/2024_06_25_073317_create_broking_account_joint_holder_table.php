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
        Schema::create('broking_account_joint_holder', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broking_account_id')->constrained()->onDelete('cascade');
            $table->foreignId('beneficiary_id')->constrained('beneficiaries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broking_account_joint_holder');
    }
};
