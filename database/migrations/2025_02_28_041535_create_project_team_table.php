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
        Schema::create('project_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('architect_id')->nullable()->constrained('architect')->onDelete('cascade');
            $table->foreignId('mechanical_electrical_id')->nullable()->constrained('mechanical_electrical')->onDelete('cascade');
            $table->foreignId('civil_structural_id')->nullable()->constrained('civil_structural')->onDelete('cascade');
            $table->foreignId('quantity_surveyor_id')->nullable()->constrained('quantity_surveyor')->onDelete('cascade');
            $table->foreignId('others_id')->nullable()->constrained('others')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_team');
    }
};
