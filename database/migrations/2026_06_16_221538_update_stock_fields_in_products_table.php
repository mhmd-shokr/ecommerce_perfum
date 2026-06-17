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
        Schema::table('products', function (Blueprint $table) {
            
        $table->renameColumn('stock', 'stock_quantity');

        $table->integer('low_stock_threshold')
            ->default(5);

        $table->boolean('is_out_of_stock')
            ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('stock_quantity', 'stock');

        $table->dropColumn('low_stock_threshold');

        $table->dropColumn('is_out_of_stock');
        });
    }
};
