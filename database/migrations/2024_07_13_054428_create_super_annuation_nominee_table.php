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
        Schema::create('super_annuation_nominee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('super_annuation_id');
            $table->unsignedBigInteger('beneficiary_id')->nullable(); // This corresponds to nominee_id
        
            $table->foreign('super_annuation_id')->references('id')->on('super_annuations')->onDelete('cascade');
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_annuation_nominee');
    }
};
