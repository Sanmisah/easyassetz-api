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
        Schema::create('commercial_property_nominee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_property_id')->constrained()->onDelete('cascade');
            $table->foreignId('beneficiary_id')->contrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_property_nominee');
    }
};
