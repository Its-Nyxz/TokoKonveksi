<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            KategoriSeeder::class,
            PenggunaSeeder::class,
            ProdukSeeder::class,
            PembelianSeeder::class,
            PembelianProdukSeeder::class,
            PembayaranSeeder::class,
            PembelianFotoSeeder::class,
        ]);
    }
}
