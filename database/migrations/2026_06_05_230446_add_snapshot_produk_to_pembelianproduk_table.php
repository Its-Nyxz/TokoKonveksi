<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('pembelianproduk', function (Blueprint $table) {
            if (!Schema::hasColumn('pembelianproduk', 'foto_produk')) {
                $table->string('foto_produk')->nullable()->after('subharga');
            }

            if (!Schema::hasColumn('pembelianproduk', 'idkategori_snapshot')) {
                $table->unsignedBigInteger('idkategori_snapshot')->nullable()->after('foto_produk');
            }

            if (!Schema::hasColumn('pembelianproduk', 'namakategori_snapshot')) {
                $table->string('namakategori_snapshot')->nullable()->after('idkategori_snapshot');
            }
        });

        DB::statement("
            UPDATE pembelianproduk pp
            LEFT JOIN produk p ON pp.idproduk = p.idproduk
            LEFT JOIN kategori k ON p.idkategori = k.idkategori
            SET
                pp.foto_produk = COALESCE(pp.foto_produk, p.foto),
                pp.idkategori_snapshot = COALESCE(pp.idkategori_snapshot, p.idkategori),
                pp.namakategori_snapshot = COALESCE(pp.namakategori_snapshot, k.namakategori)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pembelianproduk', function (Blueprint $table) {
            if (Schema::hasColumn('pembelianproduk', 'namakategori_snapshot')) {
                $table->dropColumn('namakategori_snapshot');
            }

            if (Schema::hasColumn('pembelianproduk', 'idkategori_snapshot')) {
                $table->dropColumn('idkategori_snapshot');
            }

            if (Schema::hasColumn('pembelianproduk', 'foto_produk')) {
                $table->dropColumn('foto_produk');
            }
        });
    }
};
