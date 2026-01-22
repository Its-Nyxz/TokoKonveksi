<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pembayaran')->insert([
            [
                'idpembayaran' => 1,
                'idpembelian' => 1,
                'nama' => 'Fahrul Adib',
                'tanggaltransfer' => '2025-11-14',
                'tanggal' => '2025-11-14 00:00:00',
                'bukti' => 'bukti.png',
                'jumlah' => '108500',
                'tipe' => 'DP',
            ],
        ]);
    }
}
