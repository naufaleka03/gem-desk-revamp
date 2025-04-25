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
            // Drop existing columns that might be causing issues
            $table->dropColumn(['owned', 'asset']); 
            
            // Add or modify core columns with proper types
            $table->string('name')->change();
            $table->string('service_categories')->change();
            $table->text('description')->change();
            $table->decimal('cost', 15, 2)->change();
            $table->integer('quantity')->default(1)->change();
            $table->string('availability')->change();
            $table->string('hours')->change();
            $table->string('files')->nullable()->change();
            
            // Add foreign keys with proper naming
            if (!Schema::hasColumn('services', 'organization_id')) {
                $table->foreignId('organization_id')->nullable()->constrained();
            }
            
            if (!Schema::hasColumn('services', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Reverse the changes if needed
            $table->dropConstrainedForeignId('organization_id');
            $table->dropConstrainedForeignId('product_id');
            
            $table->string('owned')->nullable();
            $table->string('asset')->nullable();
        });
    }
};
