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
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('idproduk');
            $table->integer('idkategori')->unsigned();
            $table->text('nama');
            $table->integer('harga');
            $table->text('deskripsi');
            $table->text('foto');
            $table->integer('stok')->default(0);
            $table->date('tanggal')->useCurrent();

            $table->foreign('idkategori')
                ->references('idkategori')
                ->on('kategori')
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
        Schema::dropIfExists('produk');
    }
};
