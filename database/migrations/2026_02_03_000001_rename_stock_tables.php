<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename stock_in to stock_ins (Laravel convention)
        Schema::rename('stock_in', 'stock_ins');
        
        // Rename stock_out to stock_outs (Laravel convention)
        Schema::rename('stock_out', 'stock_outs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename back to original names
        Schema::rename('stock_ins', 'stock_in');
        Schema::rename('stock_outs', 'stock_out');
    }
};

