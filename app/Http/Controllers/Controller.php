<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function checkExpiredOrders()
    {
        // 1x24 jam pemesanan tidak ada bukti pembayaran dari sistem akan otomatis menolak pesanan
        $cutoffTime = now()->subDay()->toDateTimeString();
        $expiredOrders = DB::table('pembelian')
            ->where('statusbeli', 'Belum Bayar')
            ->where('waktu', '<', $cutoffTime)
            ->get();

        foreach ($expiredOrders as $order) {
            DB::table('pembelian')
                ->where('idpembelian', $order->idpembelian)
                ->update(['statusbeli' => 'Pesanan Di Tolak', 'updated_at' => now()]);

            // Notify admins
            $admins = DB::table('pengguna')->where('level', 'Admin')->get();
            foreach ($admins as $admin) {
                // Check if notification already exists
                $exists = DB::table('notifikasi')
                    ->where('id', $admin->id)
                    ->where('pesan', 'like', "%{$order->notransaksi}%otomatis ditolak%")
                    ->exists();

                if (!$exists) {
                    DB::table('notifikasi')->insert([
                        'id' => $admin->id,
                        'pesan' => "Pesanan {$order->notransaksi} otomatis ditolak karena tidak ada pembayaran dalam 1x24 jam.",
                        'status' => 'unread',
                        'created_at' => now()
                    ]);
                }
            }
        }
    }

    protected function checkDeliveryNotification()
    {
        // Pesanan sedang dikirim dengan est lebih dari 7 hari maka sistem akan memberikan notifikasi ke admin
        $sevenDaysAgo = now()->subDays(7)->toDateTimeString();
        $staleDeliveries = DB::table('pembelian')
            ->whereIn('statusbeli', ['Sedang Dikirim', 'Pesanan Sedang Dikirim'])
            ->where(function($query) use ($sevenDaysAgo) {
                $query->where('updated_at', '<', $sevenDaysAgo)
                      ->orWhere(function($q) use ($sevenDaysAgo) {
                          $q->whereNull('updated_at')
                            ->where('waktu', '<', $sevenDaysAgo);
                      });
            })
            ->get();

        foreach ($staleDeliveries as $order) {
            // Notify admins
            $admins = DB::table('pengguna')->where('level', 'Admin')->get();
            foreach ($admins as $admin) {
                $exists = DB::table('notifikasi')
                    ->where('id', $admin->id)
                    ->where('pesan', 'like', "%{$order->notransaksi}%dikirim lebih dari 7 hari%")
                    ->exists();

                if (!$exists) {
                    DB::table('notifikasi')->insert([
                        'id' => $admin->id,
                        'pesan' => "Pesanan {$order->notransaksi} telah dikirim lebih dari 7 hari. Harap segera periksa dan update ke selesai.",
                        'status' => 'unread',
                        'created_at' => now()
                    ]);
                }
            }
        }
    }
}
