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
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'id_organization')) {
                $table->foreignId('id_organization')->nullable()->after('hours');
            }
            
            if (!Schema::hasColumn('services', 'id_product')) {
                $table->foreignId('id_product')->nullable()->after('id_organization');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'id_organization')) {
                $table->dropColumn('id_organization');
            }
            
            if (Schema::hasColumn('services', 'id_product')) {
                $table->dropColumn('id_product');
            }
        });
    }
};
