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
        Schema::create('incident_temps', function (Blueprint $table){
            $table->id();
            $table->string('incident');
            $table->string('service')->nullable();
            $table->string('asset')->nullable();
            $table->string('probability');
            $table->string('risk_impact');
            $table->string('priority');
            $table->string('incident_desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_temps');

    }
};
