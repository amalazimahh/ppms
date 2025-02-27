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
        Schema::create('design_submission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('project')->onDelete('cascade');
            $table->date('kom')->nullable();
            $table->date('conAppr')->nullable();
            $table->date('designRev')->nullable();
            $table->date('detailedRev')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_submission');
    }
};
