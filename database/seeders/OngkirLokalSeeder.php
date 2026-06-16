<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OngkirLokalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = DB::table('lokasi_rajaongkir')->get();
        $records = [];
        
        foreach ($locations as $loc) {
            $label = strtoupper($loc->label);
            
            // Determine base cost and ETD based on region relative to Wonogiri
            if (str_contains($label, 'WONOGIRI')) {
                $baseCost = 6000;
                $etdReg = '1 Hari';
                $etdExpress = '1 Hari';
            } elseif (str_contains($label, 'JAWA TENGAH') || str_contains($label, 'YOGYAKARTA') || str_contains($label, 'SURAKARTA') || str_contains($label, 'SOLO') || str_contains($label, 'SUKOHARJO') || str_contains($label, 'KLATEN') || str_contains($label, 'BOYOLALI') || str_contains($label, 'SRAGEN') || str_contains($label, 'KARANGANYAR')) {
                $baseCost = 10000;
                $etdReg = '1-2 Hari';
                $etdExpress = '1 Hari';
            } elseif (str_contains($label, 'DKI JAKARTA') || str_contains($label, 'JAWA BARAT') || str_contains($label, 'JAWA TIMUR') || str_contains($label, 'BANTEN') || str_contains($label, 'SEMARANG') || str_contains($label, 'SURABAYA') || str_contains($label, 'BANDUNG')) {
                $baseCost = 18000;
                $etdReg = '2-3 Hari';
                $etdExpress = '1-2 Hari';
            } else {
                // Outside Java
                $baseCost = 35000;
                $etdReg = '3-5 Hari';
                $etdExpress = '2-3 Hari';
            }
            
            // Generate for JNE
            $records[] = [
                'destination_id' => $loc->id,
                'courier' => 'jne',
                'service' => 'REG',
                'description' => 'Layanan Reguler JNE',
                'cost' => $baseCost,
                'etd' => $etdReg,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $records[] = [
                'destination_id' => $loc->id,
                'courier' => 'jne',
                'service' => 'YES',
                'description' => 'Yakin Esok Sampai JNE',
                'cost' => $baseCost + 12000,
                'etd' => $etdExpress,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Generate for POS
            $records[] = [
                'destination_id' => $loc->id,
                'courier' => 'pos',
                'service' => 'KILAT',
                'description' => 'Pos Kilat Khusus',
                'cost' => max(8000, $baseCost - 3000),
                'etd' => $etdReg,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Generate for TIKI
            $records[] = [
                'destination_id' => $loc->id,
                'courier' => 'tiki',
                'service' => 'REG',
                'description' => 'Layanan Reguler TIKI',
                'cost' => max(9000, $baseCost - 1000),
                'etd' => $etdReg,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Generate for J&T
            $records[] = [
                'destination_id' => $loc->id,
                'courier' => 'jnt',
                'service' => 'EZ',
                'description' => 'J&T Regular Service',
                'cost' => $baseCost + 1000,
                'etd' => $etdReg,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Generate for SiCepat
            $records[] = [
                'destination_id' => $loc->id,
                'courier' => 'sicepat',
                'service' => 'REG',
                'description' => 'SiCepat Reguler',
                'cost' => $baseCost,
                'etd' => $etdReg,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Generate for AnterAja
            $records[] = [
                'destination_id' => $loc->id,
                'courier' => 'anteraja',
                'service' => 'REG',
                'description' => 'AnterAja Regular',
                'cost' => max(9000, $baseCost - 500),
                'etd' => $etdReg,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('ongkir_lokal')->delete();
        foreach (array_chunk($records, 150) as $chunk) {
            DB::table('ongkir_lokal')->insert($chunk);
        }
    }
}
