<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiRajaongkirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = "https://raw.githubusercontent.com/yolkmonday/datawilayahindonesia/master/kecamatan_id.json";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        
        $wrapped = "[" . trim($data) . "]";
        $items = json_decode($wrapped, true);

        if (!$items || count($items) === 0) {
            throw new \Exception("Gagal mengambil atau mendekode data kecamatan dari GitHub.");
        }

        $records = [];
        foreach ($items as $item) {
            $records[] = [
                'id' => $item['subdistrict_id'],
                'label' => strtoupper($item['subdistrict_name']),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('lokasi_rajaongkir')->delete();
        foreach (array_chunk($records, 500) as $chunk) {
            DB::table('lokasi_rajaongkir')->insert($chunk);
        }
    }
}
