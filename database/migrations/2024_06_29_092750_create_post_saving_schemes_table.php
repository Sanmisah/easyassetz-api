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
        Schema::create('post_saving_schemes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('certificate_number')->nullable();
            $table->date('maturity_date')->nullable();
            $table->string('amount')->nullable();
            $table->enum('holding_type',['single','joint'])->nullable();
            $table->string('joint_holders_pan')->nullable();
            $table->string('additional_details')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('post_saving_schemes');
    }
};
