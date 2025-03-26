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
            $table->foreignId('project_id')->nullable()->constrained('project')->onDelete('set null');
            $table->foreignId('officer_in_charge')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('architect_id')->nullable()->constrained('architect');
            $table->foreignId('mechanical_electrical_id')->nullable()->constrained('mechanical_electrical');
            $table->foreignId('civil_structural_id')->nullable()->constrained('civil_structural');
            $table->foreignId('quantity_surveyor_id')->nullable()->constrained('quantity_surveyor');
            $table->foreignId('others_id')->nullable()->constrained('others');
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
