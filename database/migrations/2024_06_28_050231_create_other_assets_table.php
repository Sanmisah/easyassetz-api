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
        Schema::create('other_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('four_wheeler')->nullable();
            $table->string('company')->nullable();
            $table->string('model')->nullable();
            $table->string('registration_number')->nullable();
            $table->date('year_of_manufacture')->nullable();
            $table->date('year_of_expiry')->nullable();
            $table->string('location')->nullable();
            $table->string('huf_name')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('huf_share')->nullable();
            $table->string('jewellery_type')->nullable();
            $table->string('metal')->nullable();
            $table->string('precious_stone')->nullable();
            $table->string('weight_per_jewellery')->nullable();
            $table->string('quantity')->nullable();
            $table->string('type_of_artifacts')->nullable();
            $table->string('artist_name')->nullable();
            $table->string('painting_name')->nullable();
            $table->string('number_of_articles')->nullable();
            $table->string('digital_assets')->nullable();
            $table->string('account')->nullable();
            $table->string('linked_mobile_number')->nullable();
            $table->string('description')->nullable();
            $table->string('name_of_asset')->nullable();
            $table->string('asset_description')->nullable();
            $table->string('name_of_borrower')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->enum('mode_of_loan',['cash','cheque'])->nullable();
            $table->string('amount')->nullable();
            $table->date('due_date')->nullable();
            $table->string('additional_information')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_issuing_bank')->nullable();
            $table->string('jewellery_images')->nullable();
            $table->string('watch_images')->nullable();
            $table->string('artifact_images')->nullable();
            $table->string('other_asset_images')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_assets');
    }
};