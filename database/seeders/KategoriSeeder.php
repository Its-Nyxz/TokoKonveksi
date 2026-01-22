<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            [
                'idkategori' => 20,
                'namakategori' => 'Kaos Olahraga',
                'created_at' => '2024-10-02 02:49:32',
                'updated_at' => '2025-11-14 03:17:32',
            ],
            [
                'idkategori' => 21,
                'namakategori' => 'Seragam',
                'created_at' => '2024-10-02 08:17:18',
                'updated_at' => '2025-11-14 03:17:40',
            ],
            [
                'idkategori' => 22,
                'namakategori' => 'Jaket',
                'created_at' => '2025-11-14 03:19:17',
                'updated_at' => '2025-11-14 03:19:17',
            ],
        ]);
    }
}
