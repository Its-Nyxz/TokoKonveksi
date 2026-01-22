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
        Schema::create('pembelianproduk', function (Blueprint $table) {
            $table->increments('idpembelianproduk');
            $table->integer('idpembelian')->unsigned();
            $table->integer('idproduk')->unsigned();
            $table->text('nama');
            $table->text('harga');
            $table->text('subharga');
            $table->text('jumlah');

            $table->foreign('idpembelian')
                ->references('idpembelian')
                ->on('pembelian')
                ->onDelete('cascade');

            $table->foreign('idproduk')
                ->references('idproduk')
                ->on('produk')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelianproduk');
    }
};
