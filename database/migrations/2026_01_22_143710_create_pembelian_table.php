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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->increments('idpembelian');
            $table->text('notransaksi');
            $table->integer('id')->unsigned(); // user
            $table->date('tanggalbeli');
            $table->string('ongkir')->default('0');
            $table->text('totalbeli');
            $table->text('alamat');
            $table->text('statusbeli');
            $table->dateTime('waktu');
            $table->text('lokasi')->nullable();
            $table->string('nama', 250);
            $table->string('email', 500);
            $table->string('telepon', 250);
            $table->string('metodepembayaran', 250);
            $table->text('catatan');
            $table->text('qrcode');
            $table->string('tipepembayaran')->default('Lunas');

            $table->foreign('id')
                ->references('id')
                ->on('pengguna')
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
        Schema::dropIfExists('pembelian');
    }
};
