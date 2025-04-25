<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table){
           $table->id();
           $table->string('title');
           $table->text('description');
           $table->integer('user_id');
           $table->string('ticket_type');
           $table->string('files');
           $table->string('status');
           $table->tinyInteger('is_resolved');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tickets');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
