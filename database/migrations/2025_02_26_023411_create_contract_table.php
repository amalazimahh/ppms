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
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('project')->onDelete('cascade');
            $table->foreignId('contractor_id')->constrained('contractor')->onDelete('cascade');
            $table->string('contractNum')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('period')->nullable();
            $table->decimal('sum', 15, 2)->nullable();
            $table->decimal('revSum', 15, 2)->nullable();
            $table->decimal('lad', 15, 2)->nullable();
            $table->decimal('totalLad', 15, 2)->nullable();
            $table->date('cnc')->nullable();
            $table->date('revComp')->nullable();
            $table->date('actualComp')->nullable();
            $table->date('cpc')->nullable();
            $table->date('edlp')->nullable();
            $table->date('cmgd')->nullable();
            $table->date('lsk')->nullable();
            $table->decimal('penAmt', 15, 2)->nullable();
            $table->decimal('retAmt', 15, 2)->nullable();
            $table->date('statDec')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract');
    }
};
