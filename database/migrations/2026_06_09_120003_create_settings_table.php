<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
        });

        // Seed default values
        $defaults = [
            'tentang_kami_judul' => 'Tentang Oldshine Konveksi',
            'tentang_kami_isi' => 'Oldshine Konveksi adalah brand terpercaya yang bergerak di bidang konveksi dan produksi pakaian custom. Kami menyediakan berbagai jenis pakaian berkualitas seperti kaos, kemeja, hoodie, jaket, dan seragam untuk kebutuhan pribadi, komunitas, perusahaan, hingga event. Setiap produk dikerjakan dengan standar tinggi, menggunakan bahan pilihan dan proses produksi yang rapi serta profesional.',
            'tentang_kami_foto' => 'logo.jpg',
            'layanan_subjudul' => 'Kami berkomitmen memberikan layanan terbaik dalam setiap proses produksi pakaian Anda.',
            'layanan_1_judul' => 'Kualitas Terbaik',
            'layanan_1_isi' => 'Setiap produk dibuat dengan standar kualitas tinggi dan kontrol yang ketat.',
            'layanan_2_judul' => 'Bahan Premium',
            'layanan_2_isi' => 'Menggunakan material pilihan yang nyaman, awet, dan sesuai kebutuhan Anda.',
            'layanan_3_judul' => 'Desain Custom',
            'layanan_3_isi' => 'Menerima pesanan dengan desain khusus sesuai keinginan pelanggan.',
            'layanan_4_judul' => 'Pembayaran Mudah',
            'layanan_4_isi' => 'Transaksi fleksibel dan dapat dilakukan melalui berbagai metode pembayaran.',
            'promosi_tipe' => 'mati',
            'promosi_produk_id' => '',
        ];

        foreach ($defaults as $key => $val) {
            \Illuminate\Support\Facades\DB::table('settings')->insert(['key' => $key, 'value' => $val]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
