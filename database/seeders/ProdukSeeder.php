<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produk')->insert([
            [
                'idproduk' => 1,
                'idkategori' => 20,
                'nama' => 'Kaos Olahraga Dry Fit Lengan Pendek',
                'harga' => 75000,
                'deskripsi' => 'Kaos olahraga berbahan dry fit premium',
                'foto' => '495e7ba9.jpg',
                'stok' => 99999,
                'tanggal' => '2025-11-14',
            ],
            [
                'idproduk' => 2,
                'idkategori' => 20,
                'nama' => 'Kaos Training Sportwear Stretch Active',
                'harga' => 89000,
                'deskripsi' => 'Kaos training stretch breathable',
                'foto' => 'id-11134207.jpeg',
                'stok' => 99999,
                'tanggal' => '2025-11-14',
            ],
            [
                'idproduk' => 6,
                'idkategori' => 22,
                'nama' => 'Jaket Bomber Waterproof Windproof',
                'harga' => 195000,
                'deskripsi' => 'Jaket waterproof windproof',
                'foto' => 'bomber.jpeg',
                'stok' => 99999,
                'tanggal' => '2025-11-14',
            ],
        ]);
    }
}
