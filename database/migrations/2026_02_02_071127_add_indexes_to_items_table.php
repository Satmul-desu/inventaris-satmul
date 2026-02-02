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
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Drop indexes when rolling back
            $table->dropIndex(['stock']);
            $table->dropIndex(['min_stock']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['stock', 'min_stock']);
        });
    }
};
