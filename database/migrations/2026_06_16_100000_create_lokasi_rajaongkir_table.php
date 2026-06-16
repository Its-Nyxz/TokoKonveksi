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
        if (!Schema::hasTable('lokasi_rajaongkir')) {
            Schema::create('lokasi_rajaongkir', function (Blueprint $table) {
                $table->integer('id')->primary(); // RajaOngkir / Komerce destination ID
                $table->string('label');         // Full label: "WONOGIRI, KABUPATEN WONOGIRI, JAWA TENGAH, 57612"
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lokasi_rajaongkir');
    }
};
