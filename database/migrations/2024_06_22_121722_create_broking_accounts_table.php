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
        Schema::create('broking_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('broker_name')->nullable();
            $table->string('broking_account_number')->nullable();
            $table->enum('nature_of_holding',['single','joint'])->nullable();
            $table->string('additional_details')->nullable();
            $table->string('joint_holder_name')->nullable();
            $table->string('joint_holder_pan')->nullable();
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
        Schema::dropIfExists('broking_accounts');
    }
};
