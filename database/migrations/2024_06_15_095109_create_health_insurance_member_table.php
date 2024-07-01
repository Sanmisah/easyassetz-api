<?php

use App\Models\OtherDeposite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('health_insurance_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('health_insurance_id')->constrained()->onDelete('cascade');
            $table->foreignId('beneficiary_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_insurance_member');
    }
};
