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
            'footer_nama_toko' => 'Oldshine Konveksi',
            'footer_alamat' => 'Piji, Pijiharjo, Manyaran, Wonogiri',
            'footer_telepon' => '0852-2924-7413',
            'footer_wa_link' => 'https://wa.me/6285229247413',
            'footer_jam_hari' => 'Setiap Hari',
            'footer_jam_waktu' => '08.00 - 16.00 WIB',
            'footer_maps' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1661.7125436207446!2d110.82212371797154!3d-7.869856493083081!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a33ee9783edb5%3A0x8802aec1ac11570f!2sPiji%2C%20Pijiharjo%2C%20Kec.%20Manyaran%2C%20Kabupaten%20Wonogiri%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1763090164142!5m2!1sid!2sid',
            'footer_copyright' => 'Copyright © 2023 Oldshine Konveksi | All Rights Reserved',
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
