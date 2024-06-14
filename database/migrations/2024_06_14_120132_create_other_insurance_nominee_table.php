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
        Schema::create('other_insurance_nominee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('other_insurance_id')->constrained()->onDelete('cascade');
            $table->foreignId('beneficiary_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_insurance_nominee');
    }
};
