<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pembelian')->insert([
            [
                'idpembelian' => 1,
                'notransaksi' => '#TP20251114045638',
                'id' => 1,
                'tanggalbeli' => '2025-11-14',
                'ongkir' => '22000',
                'totalbeli' => '195000',
                'alamat' => 'Jl. Prapanca Raya No. 9',
                'statusbeli' => 'Selesai',
                'waktu' => '2025-11-14 16:56:38',
                'lokasi' => 'Palembang',
                'nama' => 'Fahrul Adib',
                'email' => 'fahruladib9@gmail.com',
                'telepon' => '082282076702',
                'metodepembayaran' => 'Transfer',
                'catatan' => 'asdsad',
                'qrcode' => 'qr_1.svg',
                'tipepembayaran' => 'Lunas',
            ],
        ]);
    }
}
