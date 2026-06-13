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
        Schema::create('promosi_produk', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_promosi')->unsigned();
            $table->integer('idproduk')->unsigned();

            $table->foreign('id_promosi')
                ->references('id_promosi')
                ->on('promosi')
                ->onDelete('cascade');

            $table->foreign('idproduk')
                ->references('idproduk')
                ->on('produk')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promosi_produk');
    }
};
