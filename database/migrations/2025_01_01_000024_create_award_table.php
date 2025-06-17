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
        Schema::create('award', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tender')->onDelete('cascade');
            $table->date('loaIssued')->nullable();
            $table->date('loa')->nullable();
            $table->date('ladDay')->nullable();
            $table->date('docPrep')->nullable();
            $table->date('conSigned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('award');
    }
};
