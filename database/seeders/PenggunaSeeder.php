<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengguna')->insert([
            [
                'id' => 1,
                'nama' => 'Fahrul Adib',
                'email' => 'fahruladib9@gmail.com',
                'password' => Hash::make('123'),
                'telepon' => '082282076702',
                'alamat' => 'Jl. Prapanca Raya No. 9',
                'fotoprofil' => 'Untitled.png',
                'level' => 'Pelanggan',
                'tgl_lahir' => '2002-07-08',
                'tempat_lahir' => 'Jakarta',
                'jekel' => 'Laki-laki',
                'provinsi' => 'DKI Jakarta',
                'kota' => 'Jakarta Selatan',
                'kec' => 'Ciganjur',
                'kode_pos' => '12170',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'telepon' => '081293827383',
                'alamat' => 'Palembang',
                'fotoprofil' => '',
                'level' => 'Admin',
                'tgl_lahir' => null,
                'tempat_lahir' => null,
                'jekel' => null,
                'provinsi' => null,
                'kota' => null,
                'kec' => null,
                'kode_pos' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama' => 'SuperAdmin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('123'),
                'telepon' => '081293827383',
                'alamat' => 'Palembang',
                'fotoprofil' => '',
                'level' => 'Admin',
                'tgl_lahir' => null,
                'tempat_lahir' => null,
                'jekel' => null,
                'provinsi' => null,
                'kota' => null,
                'kec' => null,
                'kode_pos' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'nama' => 'Produksi',
                'email' => 'produksi@gmail.com',
                'password' => Hash::make('123'),
                'telepon' => '082282076702',
                'alamat' => 'Banyuasin',
                'fotoprofil' => '',
                'level' => 'Tim Produksi',
                'tgl_lahir' => '2000-11-11',
                'tempat_lahir' => 'Banyuasin',
                'jekel' => 'Laki-laki',
                'provinsi' => null,
                'kota' => null,
                'kec' => null,
                'kode_pos' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'nama' => 'Owner',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('123'),
                'telepon' => '082282076702',
                'alamat' => 'Jl. Prapanca Raya No. 9',
                'fotoprofil' => 'Untitled.png',
                'level' => 'Owner',
                'tgl_lahir' => '2002-07-08',
                'tempat_lahir' => 'Jakarta',
                'jekel' => 'Laki-laki',
                'provinsi' => 'DKI Jakarta',
                'kota' => 'Jakarta Selatan',
                'kec' => 'Ciganjur',
                'kode_pos' => '12170',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
