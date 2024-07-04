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
        Schema::create('other_deposites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('fd_number')->nullable();
            $table->string('company')->nullable();
            $table->string('branch_name')->nullable();
            $table->date('maturity_date')->nullable();
            $table->decimal('maturity_amount',12,2)->nullable();
            $table->enum('holding_type',['single','joint'])->nullable();
            $table->string('joint_holder_name')->nullable();
            $table->string('joint_holder_pan')->nullable();
            $table->string('additional_details')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_deposites');
    }
};
