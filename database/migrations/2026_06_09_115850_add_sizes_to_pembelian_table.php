<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembelian', function (Blueprint $table) {
            $table->integer('size_m')->default(0);
            $table->integer('size_l')->default(0);
            $table->integer('size_xl')->default(0);
            $table->integer('size_xxl')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian', function (Blueprint $table) {
            $table->dropColumn(['size_m', 'size_l', 'size_xl', 'size_xxl']);
        });
    }
};
