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
        Schema::table('pembelianproduk', function (Blueprint $table) {
            if (!Schema::hasColumn('pembelianproduk', 'is_bonus')) {
                $table->tinyInteger('is_bonus')->default(0)->after('size_xxl')
                      ->comment('1 = produk bonus kelipatan lusin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelianproduk', function (Blueprint $table) {
            if (Schema::hasColumn('pembelianproduk', 'is_bonus')) {
                $table->dropColumn('is_bonus');
            }
        });
    }
};
