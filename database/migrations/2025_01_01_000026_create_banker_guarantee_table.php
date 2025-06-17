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
        Schema::create('banker_guarantee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contract')->onDelete('cascade');
            $table->decimal('bgAmt', 15, 2)->nullable();
            $table->date('bgIssued')->nullable();
            $table->date('bgExpiry')->nullable();
            $table->date('bgExt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banker_guarantee');
    }
};
