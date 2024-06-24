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
        Schema::create('business_asset_joint_holder', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_asset_id')->constrained('business_assets')->onDelete('cascade');
            $table->foreignId('joint_holder_id')->constrained('beneficiaries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_asset_joint_holder');
    }
};
