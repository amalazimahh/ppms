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
        Schema::create('tender', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('project')->onDelete('cascade');
            $table->date('confirmFund')->nullable();
            $table->decimal('costAmt', 15, 2)->nullable();
            $table->date('costDate')->nullable();
            $table->string('tenderNum')->nullable();
            $table->date('openedFirst')->nullable();
            $table->date('openedSec')->nullable();
            $table->date('closed')->nullable();
            $table->date('ext')->nullable();
            $table->date('validity')->nullable();
            $table->date('validity_ext')->nullable();
            $table->date('cancelled')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender');
    }
};
