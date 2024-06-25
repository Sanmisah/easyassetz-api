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
        Schema::create('e_s_o_p_nominee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('e_s_o_p_id')->constrained('e_s_o_p_s')->onDelete('cascade');
            $table->foreignId('beneficiary_id')->constrained('beneficiaries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_s_o_p_nominee');
    }
};
