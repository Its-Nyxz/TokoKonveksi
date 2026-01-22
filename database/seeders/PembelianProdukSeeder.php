<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembelianProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pembelianproduk')->insert([
            [
                'idpembelianproduk' => 1,
                'idpembelian' => 1,
                'idproduk' => 6,
                'nama' => 'Jaket Bomber Waterproof Windproof',
                'harga' => '195000',
                'subharga' => '195000',
                'jumlah' => '1',
            ],
        ]);
    }
}
