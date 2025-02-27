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
        Schema::table('project_team', function (Blueprint $table) {
            // drop the existing column
            $table->dropColumn(['architect', 'me', 'cs', 'qs', 'others']);

            // add FK for respective tables
            $table->foreignId('architect_id')->constrained('architect')->onDelete('cascade');
            $table->foreignId('mechanical_electrical_id')->constrained('mechanical_electrical')->onDelete('cascade');
            $table->foreignId('civil_structural_id')->constrained('civil_structural')->onDelete('cascade');
            $table->foreignId('quantity_surveyor_id')->constrained('quantity_surveyor')->onDelete('cascade');
            $table->foreignId('others_id')->constrained('others')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_team', function (Blueprint $table) {
            $table->foreignId(['architect_id']);
            $table->foreignId(['mechanical_electrical_id']);
            $table->foreignId(['civil_structural_id']);
            $table->foreignId(['quantity_surveyor_id']);
            $table->foreignId(['others_id']);

            $table->string('architect')->nullable();
            $table->string('me')->nullable();
            $table->string('cs')->nullable();
            $table->string('qs')->nullable();
            $table->string('others')->nullable();
        });
    }
};
