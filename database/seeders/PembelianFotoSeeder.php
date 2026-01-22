<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembelianFotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pembelian_foto')->insert([
            [
                'id_pembelian_foto' => 1,
                'id_pembelian' => 1,
                'status' => 'Pesanan Sedang Dikirim',
                'foto' => 'pengiriman.png',
                'fotobuktiditerima' => null,
            ],
        ]);
    }
}
