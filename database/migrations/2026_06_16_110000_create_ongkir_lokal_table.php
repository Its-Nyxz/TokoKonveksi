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
        if (!Schema::hasTable('ongkir_lokal')) {
            Schema::create('ongkir_lokal', function (Blueprint $table) {
                $table->id();
                $table->integer('destination_id'); // matches lokasi_rajaongkir.id
                $table->string('courier');         // jne, pos, tiki, jnt, sicepat, anteraja
                $table->string('service');         // REG, YES, KILAT, EZ, etc.
                $table->string('description');
                $table->integer('cost');
                $table->string('etd');             // e.g. "2-3 Hari"
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
        Schema::dropIfExists('ongkir_lokal');
    }
};
