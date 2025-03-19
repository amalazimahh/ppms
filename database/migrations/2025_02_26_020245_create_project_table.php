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
            $table->string('fy')->nullable();
            $table->decimal('sv', 15, 2)->nullable();
            $table->decimal('av', 15, 2)->nullable();
            $table->string('voteNum')->nullable();
            $table->string('title')->nullable();
            $table->string('siteGazette')->nullable();
            $table->text('scope')->nullable();
            $table->text('location')->nullable();
            $table->string('img')->nullable();
            $table->timestamps();

            // foreign keys
            $table->foreignId('statuses_id')->nullable()->constrained('statuses')->onDelete('cascade');
            $table->foreignId('parent_project_id')->nullable()->constrained('project')->onDelete('cascade');
            $table->foreignId('client_ministry_id')->nullable()->constrained('client_ministry')->onDelete('cascade');
            $table->foreignId('project_team_id')->nullable()->constrained('project_team')->onDelete('cascade');

            // users
            $table->bigInteger('oic')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
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
