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
        Schema::create('organizations', function (Blueprint $table){
            $table->id();
            $table->string('organization_name');
            $table->text('description');
            $table->string('industry_category');
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('state');
            $table->string('country');
            $table->string('email');
            $table->string('phone_no');
            $table->string('fax_no');
            $table->string('web_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};