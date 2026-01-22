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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('idpembayaran');
            $table->integer('idpembelian')->unsigned();
            $table->text('nama');
            $table->text('tanggaltransfer');
            $table->dateTime('tanggal');
            $table->text('bukti');
            $table->string('jumlah');
            $table->string('tipe')->default('Lunas');

            $table->foreign('idpembelian')
                ->references('idpembelian')
                ->on('pembelian')
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
        Schema::dropIfExists('pembayaran');
    }
};
