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
        Schema::create('pembelian_foto', function (Blueprint $table) {
            $table->increments('id_pembelian_foto');
            $table->integer('id_pembelian')->unsigned();
            $table->text('status');
            $table->text('foto');
            $table->text('fotobuktiditerima')->nullable();

            $table->foreign('id_pembelian')
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
        Schema::dropIfExists('pembelian_foto');
    }
};
