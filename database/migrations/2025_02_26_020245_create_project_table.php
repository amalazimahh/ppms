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
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string('customID')->nullable();
            $table->string('fy')->nullable();
            $table->decimal('sv', 15, 2)->nullable();
            $table->decimal('av', 15, 2)->nullable();
            $table->foreignId('statuses_id')->constrained('statuses')->onDelete('cascade');
            $table->string('voteNum')->nullable();
            $table->string('title')->nullable();
            $table->bigInteger('oic')->unsigned()->nullable();
            $table->foreignId('client_ministry_id')->constrained('client_ministry')->onDelete('cascade');
            $table->foreignId('contractor_id')->constrained('contractor')->onDelete('cascade');
            $table->string('contractorNum')->nullable();
            $table->string('siteGazette')->nullable();
            $table->date('soilInv')->nullable();
            $table->date('topoSurvey')->nullable();
            $table->date('handover')->nullable();
            $table->text('scope')->nullable();
            $table->text('location')->nullable();
            $table->binary('img')->nullable();
            $table->foreignId('project_team_id')->constrained('project_team')->onDelete('cascade');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('oic')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
