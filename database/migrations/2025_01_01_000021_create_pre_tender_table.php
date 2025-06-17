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
        Schema::create('pre_tender', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('project')->onDelete('cascade');
            $table-> string('rfpRfqNum')->nullable();
            $table->string('rfqTitle')->nullable();
            $table->decimal('rfqFee', 15, 2)->nullable();
            $table->date('opened')->nullable();
            $table->date('closed')->nullable();
            $table->date('ext')->nullable();
            $table->date('validity_ext')->nullable();
            $table->date('jkmkkp_recomm')->nullable();
            $table->date('jkmkkp_approval')->nullable();
            $table->date('loa')->nullable();
            $table->date('aac')->nullable();
            $table->date('soilInv')->nullable();
            $table->date('topoSurvey')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_tender');
    }
};
