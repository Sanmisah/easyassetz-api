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
        Schema::create('wealth_management_nominee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wealth_management_id')->constrained('wealth_management_accounts')->onDelete('cascade');
            $table->foreignId('nominee_id')->constrained('beneficiaries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wealth_management_nominee');
    }
};
