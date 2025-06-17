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
        Schema::create('tender_recommendation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tender')->onDelete('cascade');
            $table->date('toConsultant')->nullable();
            $table->date('fromConsultant')->nullable();
            $table->date('fromBPP')->nullable();
            $table->date('toDG')->nullable();
            $table->date('toLTK')->nullable();
            $table->date('ltkApproval')->nullable();
            $table->date('discLetter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_recommendation');
    }
};
