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
        Schema::create('bullions', function (Blueprint $table) {
            $table->id();
            $table->foreignID('profile_id')->constrained()->onDelete('cascade');
            $table->string('metal_type')->nullable();
            $table->string('article_details')->nullable();
            $table->string('weight_per_article')->nullable();
            $table->decimal('number_of_articles')->nullable();
            $table->string('additional_information')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bullions');
    }
};