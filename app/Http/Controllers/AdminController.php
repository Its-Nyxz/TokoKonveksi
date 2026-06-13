<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $this->checkExpiredOrders();
        $this->checkDeliveryNotification();

        // Date Range Filters
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $queryPesanan = DB::table('pembelian');
        $queryRevenue = DB::table('pembelian')
            ->whereIn('statusbeli', ['Pesanan Di Terima', 'Selesai']);

        if (!empty($startDate) && !empty($endDate)) {
            $queryPesanan->whereBetween('tanggalbeli', [$startDate, $endDate]);
            $queryRevenue->whereBetween('tanggalbeli', [$startDate, $endDate]);
        }

        $jumlahPesanan = $queryPesanan->count();
        $jumlahUser = DB::table('pengguna')->where('level', 'Pelanggan')->count();
        $totalRevenue = $queryRevenue->sum(DB::raw('totalbeli + ongkir'));

        // Chart Data Queries
        $revenueDataQuery = DB::table('pembelian')
            ->select(DB::raw('DATE(tanggalbeli) as date'), DB::raw('SUM(totalbeli + ongkir) as total'))
            ->whereIn('statusbeli', ['Pesanan Di Terima', 'Selesai'])
            ->groupBy('date')
            ->orderBy('date', 'asc');

        $orderDataQuery = DB::table('pembelian')
            ->select(DB::raw('DATE(tanggalbeli) as date'), DB::raw('count(*) as jumlah'))
            ->groupBy('date')
            ->orderBy('date', 'asc');

        $pieDataQuery = DB::table('pembelian')
            ->select('tipepembayaran', DB::raw('count(*) as jumlah'))
            ->groupBy('tipepembayaran');

        if (!empty($startDate) && !empty($endDate)) {
            $revenueDataQuery->whereBetween('tanggalbeli', [$startDate, $endDate]);
            $orderDataQuery->whereBetween('tanggalbeli', [$startDate, $endDate]);
            $pieDataQuery->whereBetween('tanggalbeli', [$startDate, $endDate]);
        }

        $revenueData = $revenueDataQuery->get();
        $orderData = $orderDataQuery->get();
        $pieData = $pieDataQuery->get();

        $revenueLabels = $revenueData->pluck('date');
        $revenueValues = $revenueData->pluck('total');

        $orderLabels = $orderData->pluck('date');
        $orderValues = $orderData->pluck('jumlah');

        $pieLabels = $pieData->pluck('tipepembayaran')->map(function($val) {
            return empty($val) ? 'Lunas' : $val;
        });
        $pieValues = $pieData->pluck('jumlah');

        return view('admin.dashboard', [
            'jumlahPesanan' => $jumlahPesanan,
            'jumlahUser' => $jumlahUser,
            'totalRevenue' => $totalRevenue,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'revenueLabels' => $revenueLabels,
            'revenueValues' => $revenueValues,
            'orderLabels' => $orderLabels,
            'orderValues' => $orderValues,
            'pieLabels' => $pieLabels,
            'pieValues' => $pieValues,
        ]);
    }

    public function kategori()
    {
        $data['kategori'] = DB::table('kategori')->get();
        return view('admin.kategori', $data);
    }

    public function tambahkategori()
    {

        return view('admin.tambahkategori');
    }

    public function simpankategori(Request $request)
    {
        $data = [
            'namakategori' => $request->kategori,
            'idkategori' => $request->kategori,
        ];
        KategoriModel::create($data);
        session()->flash('alert', 'Berhasil menambahkan data!');
        return redirect('admin/kategori');
    }

    public function ubahkategori($id)
    {
        $data['kategori'] = KategoriModel::where('idkategori', $id)->first();
        return view('admin.ubahkategori', $data);
    }

    public function updatekategori(Request $request, $id)
    {
        $data = [
            'namakategori' => $request->kategori
        ];
        KategoriModel::where('idkategori', $id)->update($data);
        session()->flash('alert', 'Berhasil mengubah data!');
        return redirect('admin/kategori');
    }

    public function hapuskategori($id)
    {
        $kategori = DB::table('kategori')
            ->where('idkategori', $id)
            ->first();

        if ($kategori) {
            $produkIds = DB::table('produk')
                ->where('idkategori', $id)
                ->pluck('idproduk');

            if ($produkIds->count() > 0) {
                DB::table('pembelianproduk')
                    ->whereIn('idproduk', $produkIds)
                    ->whereNull('idkategori_snapshot')
                    ->update([
                        'idkategori_snapshot' => $id,
                    ]);

                DB::table('pembelianproduk')
                    ->whereIn('idproduk', $produkIds)
                    ->whereNull('namakategori_snapshot')
                    ->update([
                        'namakategori_snapshot' => $kategori->namakategori,
                    ]);
            }

            KategoriModel::where('idkategori', $id)->delete();
        }

        session()->flash('alert', 'Berhasil menghapus data!');
        return redirect('admin/kategori');
    }

    public function timproduksi()
    {
        $data['timproduksi'] = DB::table('pengguna')->where('level', 'Tim Produksi')->get();
        return view('admin.timproduksi', $data);
    }

    public function tambahtimproduksi()
    {
        return view('admin.tambahtimproduksi');
    }

    public function simpantimproduksi(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password, // disarankan hash
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tgl_lahir' => $request->tgl_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'jekel' => $request->jekel,
            'level' => 'Tim Produksi',
            'fotoprofil' => '', // default kosong atau bisa isi default path
        ];

        DB::table('pengguna')->insert($data);

        session()->flash('alert', 'Berhasil menambahkan Tim Produksi!');
        return redirect('admin/timproduksi');
    }


    public function ubahtimproduksi($id)
    {
        $data['timproduksi'] = DB::table('pengguna')->where('id', $id)->first();
        return view('admin.ubahtimproduksi', $data);
    }
    public function updatetimproduksi(Request $request, $id)
    {
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jekel' => $request->jekel,
        ];

        // Jika password diisi, update juga
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        DB::table('pengguna')->where('id', $id)->update($data);

        session()->flash('alert', 'Berhasil mengubah data!');
        return redirect('admin/timproduksi');
    }
    public function hapustimproduksi($id)
    {
        DB::table('pengguna')->where('id', $id)->delete();
        session()->flash('alert', 'Berhasil menghapus data!');
        return redirect('admin/timproduksi');
    }



    public function produk()
    {
        $produk = DB::table('produk')->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->orderBy('idproduk', 'DESC')->get();
        $data['produk'] = $produk;
        return view('admin.produk', $data);
    }

    public function tambahproduk()
    {
        $data['kategori'] = DB::table('kategori')->get();

        return view('admin.tambahproduk', $data);
    }

    public function simpanproduk(Request $request)
    {
        $fotoNames = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $namafoto = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('foto'), $namafoto);
                $fotoNames[] = $namafoto;
            }
        }
        $fotoString = implode(',', $fotoNames);

        DB::table('produk')->insert([
            'nama' => $request->input('nama'),
            'idkategori' => $request->input('idkategori'),
            'harga' => $request->input('harga'),
            'harga_sebelum' => $request->input('harga_sebelum'),
            'stok' => $request->input('stok') ?? 999999,
            'foto' => $fotoString,
            'deskripsi' => $request->input('deskripsi'),
            'tanggal' => date('Y-m-d'),
        ]);
        session()->flash('alert', 'Berhasil menambah data!');

        return redirect('admin/produk');
    }

    public function ubahproduk($id)
    {
        $data['produk'] = DB::table('produk')->where('idproduk', $id)->first();
        $data['kategori'] = DB::table('kategori')->get();
        return view('admin.ubahproduk', $data);
    }

    public function updateproduk(Request $request, $id)
    {
        $data = [
            'nama' => $request->input('nama'),
            'idkategori' => $request->input('idkategori'),
            'harga' => $request->input('harga'),
            'harga_sebelum' => $request->input('harga_sebelum'),
            'stok' => $request->input('stok') ?? 999999,
            'deskripsi' => $request->input('deskripsi'),
        ];
        if ($request->hasFile('foto')) {
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $namafoto = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('foto'), $namafoto);
                $fotoNames[] = $namafoto;
            }
            $data['foto'] = implode(',', $fotoNames);
        }
        DB::table('produk')->where('idproduk', $id)->update($data);
        session()->flash('alert', 'Berhasil mengubah data!');
        return redirect('admin/produk');
    }

    public function hapusproduk($id)
    {
        $produk = DB::table('produk as p')
            ->leftJoin('kategori as k', 'p.idkategori', '=', 'k.idkategori')
            ->where('p.idproduk', $id)
            ->select('p.*', 'k.namakategori')
            ->first();

        if ($produk) {
            DB::table('pembelianproduk')
                ->where('idproduk', $id)
                ->whereNull('foto_produk')
                ->update([
                    'foto_produk' => $produk->foto,
                ]);

            DB::table('pembelianproduk')
                ->where('idproduk', $id)
                ->whereNull('idkategori_snapshot')
                ->update([
                    'idkategori_snapshot' => $produk->idkategori,
                ]);

            DB::table('pembelianproduk')
                ->where('idproduk', $id)
                ->whereNull('namakategori_snapshot')
                ->update([
                    'namakategori_snapshot' => $produk->namakategori,
                ]);

            DB::table('produk')->where('idproduk', $id)->delete();
        }

        session()->flash('alert', 'Berhasil menghapus data!');
        return redirect('admin/produk');
    }

    public function pengguna()
    {
        $pengguna = DB::table('pengguna')->where('level', 'Pelanggan')->get();

        $data = [
            'pengguna' => $pengguna,
        ];

        return view('admin.pengguna', $data);
    }

    public function hapuspengguna($id)
    {
        $pengguna = DB::table('pengguna')->where('id', $id)->first();
        if (!$pengguna) {
            session()->flash('error', 'Pengguna tidak ditemukan');
            return back();
        }



        DB::table('pengguna')->where('id', $id)->delete();
        session()->flash('alert', 'Berhasil menghapus data!');
        return redirect('admin/pengguna');
    }

    public function kurir()
    {
        $kurir = DB::table('pengguna')->where('level', 'Kurir')->get();

        $data = [
            'kurir' => $kurir,
        ];

        return view('admin.kurir', $data);
    }

    public function tambahkurir()
    {
        return view('admin.tambahkurir');
    }

    public function simpankurir(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:3',
            'telepon' => 'required|numeric',
            'alamat' => 'required|string',
            'fotoprofil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tgl_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'jekel' => 'required|string|in:Laki-laki,Perempuan',
        ]);

        // Upload file foto jika ada
        if ($request->hasFile('fotoprofil')) {
            $file = $request->file('fotoprofil');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto'), $filename);
        } else {
            $filename = null; // Jika tidak ada foto yang diupload
        }

        // Simpan data ke tabel pengguna dengan level Kurir
        DB::table('pengguna')->insert([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'telepon' => $request->input('telepon'),
            'alamat' => $request->input('alamat'),
            'fotoprofil' => $filename,
            'tgl_lahir' => $request->input('tgl_lahir'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'jekel' => $request->input('jekel'),
            'level' => 'Kurir',
        ]);

        // Redirect atau berikan response sukses
        return redirect('admin/kurir')->with('success', 'Kurir berhasil ditambahkan');
    }

    public function hapuskurir($id)
    {
        DB::table('pengguna')->where('id', $id)->delete();

        return redirect('admin/kurir')->with('success', 'Kurir berhasil dihapus');
    }

    public function logout()
    {
        session()->flush();
        return redirect('home')->with('alert', 'Anda Telah Logout');
    }

    public function akun()
    {
        if (!session('admin')) {
            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }

        $idpengguna = session('admin')->id;
        $pengguna = DB::table('pengguna')->where('id', $idpengguna)->first();

        $data = [
            'pengguna' => $pengguna,
        ];

        return view('admin/akun', $data);
    }

    public function ubahakun(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|min:6',
        ]);

        // Ambil data pengguna yang sedang login
        $pengguna = DB::table('pengguna')->where('id', $id)->first();

        // Cek apakah pengguna ditemukan
        if (!$pengguna) {
            return redirect('admin/akun')->with('error', 'Pengguna tidak ditemukan');
        }

        // Data yang akan diupdate
        $dataUpdate = [
            'email' => $request->input('email')
        ];

        // Cek apakah pengguna adalah Administrator (ID 2 atau nama Administrator)
        if ($pengguna->id == 2 || $pengguna->nama == 'Administrator') {
            // Administrator bisa mengubah password
            $password = $request->input('password');

            if (!empty($password)) {
                // Jika password diisi, hash password baru
                $dataUpdate['password'] = bcrypt($password);
            }
            // Jika password kosong, tidak diupdate (tetap pakai password lama)
        }
        // Jika SuperAdmin (ID 3), password tidak akan diupdate

        // Update data
        DB::table('pengguna')
            ->where('id', $id)
            ->update($dataUpdate);

        return redirect('admin/akun')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Berhasil!',
            'swal_text'  => 'Data akun berhasil diubah'
        ]);
    }

    public function pembelian()
    {
        $pembelian = DB::table('pembelian')->orderBy('pembelian.tanggalbeli', 'desc')->orderBy('pembelian.idpembelian', 'desc')->get();

        $dataproduk = [];
        foreach ($pembelian as $row) {
            $idpembelian = $row->idpembelian;
            $produk = $this->getProdukTransaksi($idpembelian);
            $dataproduk[$idpembelian] = $produk;
        }


        $data = [
            'pembelian' => $pembelian,
            'dataproduk' => $dataproduk,
        ];
        return view('admin.pembelian', $data);
    }

    public function pembeliankurir()
    {
        $pembelian = DB::table('pembelian')->where('pembelian.idkurir', session('admin')->id)->orderBy('pembelian.tanggalbeli', 'desc')->orderBy('pembelian.idpembelian', 'desc')->get();

        $dataproduk = [];
        foreach ($pembelian as $row) {
            $idpembelian = $row->idpembelian;
            $produk = $this->getProdukTransaksi($idpembelian);
            $dataproduk[$idpembelian] = $produk;
        }


        $data = [
            'pembelian' => $pembelian,
            'dataproduk' => $dataproduk,
        ];
        return view('admin.pembeliankurir', $data);
    }

    public function pembayarankurir($id)
    {
        $datapembelian = DB::table('pembelian')
            ->where('idpembelian', $id)
            ->first();

        $dataproduk = $this->getProdukTransaksi($id);

        $pembelianFoto = DB::table('pembelian_foto')
            ->where('id_pembelian', $id)
            ->get();

        $pembayaran = DB::table('pembayaran')
            ->where('idpembelian', $id)
            ->orderBy('idpembayaran')
            ->get();

        $kurir = DB::table('pengguna')
            ->where('level', 'Kurir')
            ->get();

        return view('admin.pembayarankurir', [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
            'pembayaran' => $pembayaran,
            'pembelianFoto' => $pembelianFoto,
            'kurir' => $kurir,
        ]);
    }

    public function pembayaran($id)
    {
        $datapembelian = DB::table('pembelian')
            ->where('idpembelian', $id)
            ->first();

        $dataproduk = $this->getProdukTransaksi($id);

        $pembelianFoto = DB::table('pembelian_foto')
            ->where('id_pembelian', $id)
            ->get();

        $pembayaran = DB::table('pembayaran')
            ->where('idpembelian', $id)
            ->orderBy('idpembayaran')
            ->get();

        return view('admin.pembayaran', [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
            'pembayaran' => $pembayaran,
            'pembelianFoto' => $pembelianFoto,
        ]);
    }

    public function exportpdf()
    {
        // Mengambil data pembelian dan produk
        $pembelian = DB::table('pembelian')
            ->orderBy('tanggalbeli', 'desc')
            ->orderBy('idpembelian', 'desc')
            ->get();

        $dataproduk = [];
        foreach ($pembelian as $row) {
            $idpembelian = $row->idpembelian;
            $produk = $this->getProdukTransaksi($idpembelian);
            $dataproduk[$idpembelian] = $produk;
        }

        $data = [
            'pembelian' => $pembelian,
            'dataproduk' => $dataproduk,
        ];

        // Load view untuk laporan PDF
        $view = view('admin.pembelian_pdf', $data)->render();

        // Inisialisasi DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Muat konten HTML
        $dompdf->loadHtml($view);

        // Set ukuran kertas dan orientasi (potrait atau landscape)
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        // Output PDF
        $dompdf->stream('laporan_pembelian.pdf', ['Attachment' => 1]);
    }

    public function simpanpembayarankurir($id, Request $request)
    {
        if ($request->has('proses')) {
            $statusbeli = $request->input('statusbeli');
            $pembelianproduk = DB::table('pembelianproduk')->where('idpembelian', $id)->get();

            // Validate payment proofs: admin may only set status other than 'Pesanan Di Tolak' if proof exists
            $paymentRecords = DB::table('pembayaran')->where('idpembelian', $id)->get();
            if ($statusbeli != 'Pesanan Di Tolak') {
                if ($statusbeli == 'Selesai') {
                    // To mark as Selesai, pelunasan must exist (tipe != 'DP')
                    $hasPelunasan = $paymentRecords->contains(function ($p) {
                        return isset($p->tipe) && strtolower($p->tipe) != 'dp';
                    });
                    if (!$hasPelunasan) {
                        return back()->with([
                            'swal_type' => 'warning',
                            'swal_title' => '',
                            'swal_text' => 'Tidak bisa mengubah ke Selesai — bukti pelunasan belum tersedia.'
                        ]);
                    }
                } else {
                    // For other non-reject statuses, at least one payment proof (DP or pelunasan) must exist
                    if ($paymentRecords->isEmpty()) {
                        return back()->with([
                            'swal_type' => 'warning',
                            'swal_title' => '',
                            'swal_text' => 'Harap unggah bukti pembayaran (DP atau Pelunasan) sebelum mengubah status.'
                        ]);
                    }
                }
            }

            if ($request->hasFile('foto')) {
                $namafoto = date('Ymdhis') . '-' . $request->file('foto')->getClientOriginalName();
                $request->file('foto')->move(public_path('foto'), $namafoto);

                // Insert the photo into the new table
                DB::table('pembelian_foto')->insert([
                    'id_pembelian' => $id,
                    'status' => $statusbeli,
                    'foto' => $namafoto,
                ]);
            }

            // Update status pembelian
            DB::table('pembelian')->where('idpembelian', $id)->update([
                'statusbeli' => $statusbeli,
                'catatan' => $request->input('catatan'),
            ]);

            $order = DB::table('pembelian')->where('idpembelian', $id)->first();
            if ($order) {
                DB::table('notifikasi')->insert([
                    'id' => $order->id,
                    'pesan' => "Status pesanan {$order->notransaksi} Anda telah diperbarui menjadi '{$statusbeli}'.",
                    'status' => 'unread',
                    'created_at' => now()
                ]);
            }

            if ($request->statusbeli == 'Pesanan Di Terima') {
                foreach ($pembelianproduk as $value) {
                    $idproduk = $value->idproduk;
                    $jumlahbeli = $value->jumlah;

                    $produk = DB::table('produk')
                        ->where('idproduk', $idproduk)
                        ->first();

                    if ($produk) {
                        $stokbaru = max(0, $produk->stok - $jumlahbeli);

                        DB::table('produk')
                            ->where('idproduk', $idproduk)
                            ->update([
                                'stok' => $stokbaru
                            ]);
                    }
                }
            }

            return redirect('admin/pembeliankurir');
        }
    }

    public function simpanpembayaran($id, Request $request)
    {
        if ($request->has('proses')) {
            $statusbeli = $request->input('statusbeli');
            $pembelianproduk = DB::table('pembelianproduk')->where('idpembelian', $id)->get();

            // Validate payment proofs before allowing status changes
            $paymentRecords = DB::table('pembayaran')->where('idpembelian', $id)->get();
            if ($statusbeli != 'Pesanan Di Tolak') {
                if ($statusbeli == 'Selesai') {
                    $hasPelunasan = $paymentRecords->contains(function ($p) {
                        return isset($p->tipe) && strtolower($p->tipe) != 'dp';
                    });
                    if (!$hasPelunasan) {
                        return back()->with([
                            'swal_type' => 'warning',
                            'swal_title' => '',
                            'swal_text' => 'Tidak bisa mengubah ke Selesai — bukti pelunasan belum tersedia.'
                        ]);
                    }
                } else {
                    if ($paymentRecords->isEmpty()) {
                        return back()->with([
                            'swal_type' => 'warning',
                            'swal_title' => '',
                            'swal_text' => 'Harap unggah bukti pembayaran (DP atau Pelunasan) sebelum mengubah status.'
                        ]);
                    }
                }

                // Validasi ukuran bonus harus teralokasi semua
                $bonusItems = DB::table('pembelianproduk')
                    ->where('idpembelian', $id)
                    ->where('is_bonus', 1)
                    ->get();

                foreach ($bonusItems as $bonus) {
                    $allocated = (int) $bonus->size_m + (int) $bonus->size_l + (int) $bonus->size_xl + (int) $bonus->size_xxl;
                    if ($allocated !== (int) $bonus->jumlah) {
                        return back()->with([
                            'swal_type'  => 'warning',
                            'swal_title' => 'Ukuran Bonus Belum Sesuai',
                            'swal_text'  => "Harap tentukan alokasi ukuran untuk produk bonus '{$bonus->nama}' (total {$bonus->jumlah} pcs) terlebih dahulu."
                        ]);
                    }
                }
            }

            if ($request->hasFile('foto')) {
                $namafoto = date('Ymdhis') . '-' . $request->file('foto')->getClientOriginalName();
                $request->file('foto')->move(public_path('foto'), $namafoto);

                // Insert the photo into the new table
                DB::table('pembelian_foto')->insert([
                    'id_pembelian' => $id,
                    'status' => $statusbeli,
                    'foto' => $namafoto,
                ]);
            }

            // Update status pembelian
            DB::table('pembelian')->where('idpembelian', $id)->update([
                'statusbeli' => $statusbeli,
                'catatan' => $request->input('catatan'),
            ]);

            $order = DB::table('pembelian')->where('idpembelian', $id)->first();
            if ($order) {
                DB::table('notifikasi')->insert([
                    'id' => $order->id,
                    'pesan' => "Status pesanan {$order->notransaksi} Anda telah diperbarui menjadi '{$statusbeli}'.",
                    'status' => 'unread',
                    'created_at' => now()
                ]);
            }

            if ($request->statusbeli == 'Pesanan Di Terima') {
                foreach ($pembelianproduk as $value) {
                    $idproduk = $value->idproduk;
                    $jumlahbeli = $value->jumlah;

                    $produk = DB::table('produk')
                        ->where('idproduk', $idproduk)
                        ->first();

                    if ($produk) {
                        $stokbaru = max(0, $produk->stok - $jumlahbeli);

                        DB::table('produk')
                            ->where('idproduk', $idproduk)
                            ->update([
                                'stok' => $stokbaru
                            ]);
                    }
                }
            }

            return redirect('admin/pembelian');
        }
    }

    public function laporan()
    {
        return view('admin.laporan');
    }

    public function laporancetak(Request $request)
    {
        $tanggalawal = $request->input('tanggalawal');
        $tanggalakhir = $request->input('tanggalakhir');
        $status = $request->input('status');
        $metode = $request->input('metode');

        $query = DB::table('pembelian')
            ->whereBetween('tanggalbeli', [$tanggalawal, $tanggalakhir]);

        if (!empty($status)) {
            $query->where('statusbeli', $status);
        }

        if (!empty($metode)) {
            $query->where('metodepembayaran', $metode);
        }

        $pembelian = $query->orderBy('tanggalbeli', 'desc')
            ->orderBy('idpembelian', 'desc')
            ->get();

        $dataproduk = [];

        foreach ($pembelian as $row) {
            $dataproduk[$row->idpembelian] = $this->getProdukTransaksi($row->idpembelian);
        }

        $totalPembelian = $pembelian->sum('totalbeli');

        return view('admin.laporancetak', [
            'pembelian' => $pembelian,
            'dataproduk' => $dataproduk,
            'tanggalawal' => $tanggalawal,
            'tanggalakhir' => $tanggalakhir,
            'status' => $status,
            'metode' => $metode,
            'totalPembelian' => $totalPembelian,
        ]);
    }

    public function invoice($id)
    {
        $datapembelian = DB::table('pembelian')->where('pembelian.idpembelian', $id)->first();
        $dataproduk = $this->getProdukTransaksi($id);

        // Ambil semua record pembayaran terkait (bisa ada DP dan pelunasan)
        $pembayaran = DB::table('pembayaran')->where('idpembelian', $id)->get();

        $data = [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
            'pembayaran' => $pembayaran,
        ];

        return view('home.invoice', $data);
    }

    public function settings()
    {
        $settings = DB::table('settings')->pluck('value', 'key');
        $produk = DB::table('produk')->get();
        return view('admin.settings', compact('settings', 'produk'));
    }

    public function savesettings(Request $request)
    {
        $keys = [
            'tentang_kami_judul',
            'tentang_kami_isi',
            'layanan_subjudul',
            'layanan_1_judul',
            'layanan_1_isi',
            'layanan_2_judul',
            'layanan_2_isi',
            'layanan_3_judul',
            'layanan_3_isi',
            'layanan_4_judul',
            'layanan_4_isi',
            'promosi_tipe',
            'promosi_produk_id',
        ];

        foreach ($keys as $key) {
            DB::table('settings')
                ->where('key', $key)
                ->update(['value' => $request->input($key)]);
        }

        if ($request->hasFile('tentang_kami_foto')) {
            $file = $request->file('tentang_kami_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $filename);

            DB::table('settings')
                ->where('key', 'tentang_kami_foto')
                ->update(['value' => $filename]);
        }

        return redirect('admin/settings')->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function updateukuranbonus($idpembelian, $idpembelianproduk, Request $request)
    {
        $item = DB::table('pembelianproduk')
            ->where('idpembelian', $idpembelian)
            ->where('idpembelianproduk', $idpembelianproduk)
            ->where('is_bonus', 1)
            ->first();

        if (!$item) {
            return back()->with([
                'swal_type'  => 'error',
                'swal_title' => 'Gagal',
                'swal_text'  => 'Data bonus produk tidak ditemukan.'
            ]);
        }

        $size_m   = max(0, (int) $request->input('size_m'));
        $size_l   = max(0, (int) $request->input('size_l'));
        $size_xl  = max(0, (int) $request->input('size_xl'));
        $size_xxl = max(0, (int) $request->input('size_xxl'));

        $totalAlokasi = $size_m + $size_l + $size_xl + $size_xxl;

        if ($totalAlokasi !== (int) $item->jumlah) {
            return back()->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Alokasi Ukuran Salah',
                'swal_text'  => "Total alokasi ukuran ($totalAlokasi pcs) harus sama dengan jumlah bonus ({$item->jumlah} pcs)."
            ]);
        }

        DB::table('pembelianproduk')
            ->where('idpembelianproduk', $idpembelianproduk)
            ->update([
                'size_m'   => $size_m,
                'size_l'   => $size_l,
                'size_xl'  => $size_xl,
                'size_xxl' => $size_xxl,
            ]);

        return back()->with([
            'swal_type'  => 'success',
            'swal_title' => 'Ukuran Diperbarui',
            'swal_text'  => 'Ukuran bonus produk berhasil diperbarui.'
        ]);
    }

    private function getProdukTransaksi($idpembelian)
    {
        return DB::table('pembelianproduk as pp')
            ->leftJoin('produk as p', 'pp.idproduk', '=', 'p.idproduk')
            ->leftJoin('kategori as k', 'p.idkategori', '=', 'k.idkategori')
            ->where('pp.idpembelian', $idpembelian)
            ->select(
                'pp.*',
                DB::raw("COALESCE(pp.nama, p.nama, CONCAT('Produk #', pp.idproduk, ' sudah dihapus')) as nama"),
                DB::raw("COALESCE(pp.harga, p.harga, 0) as harga"),
                DB::raw("COALESCE(pp.subharga, pp.harga * pp.jumlah, p.harga * pp.jumlah, 0) as subharga"),
                DB::raw("COALESCE(pp.foto_produk, p.foto, 'noimage.png') as foto"),
                DB::raw("COALESCE(pp.namakategori_snapshot, k.namakategori, 'Kategori sudah dihapus') as namakategori")
            )
            ->get();
    }

    public function promosi()
    {
        $promosi = DB::table('promosi')->orderBy('id_promosi', 'desc')->get();
        
        foreach ($promosi as $p) {
            $p->produk = DB::table('promosi_produk')
                ->join('produk', 'promosi_produk.idproduk', '=', 'produk.idproduk')
                ->where('promosi_produk.id_promosi', $p->id_promosi)
                ->get();
        }
        
        return view('admin.promosi.index', compact('promosi'));
    }

    public function tambahpromosi()
    {
        $produk = DB::table('produk')->get();
        return view('admin.promosi.tambah', compact('produk'));
    }

    public function simpanpromosi(Request $request)
    {
        $request->validate([
            'nama_promosi' => 'required',
        ]);
        
        $fotoName = '';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $fotoName);
        }
        
        $id_promosi = DB::table('promosi')->insertGetId([
            'nama_promosi' => $request->input('nama_promosi'),
            'deskripsi' => $request->input('deskripsi'),
            'foto' => $fotoName,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        if ($request->has('produk_ids')) {
            $produk_ids = $request->input('produk_ids');
            $pivotData = [];
            foreach ($produk_ids as $idproduk) {
                $pivotData[] = [
                    'id_promosi' => $id_promosi,
                    'idproduk' => $idproduk
                ];
            }
            DB::table('promosi_produk')->insert($pivotData);
        }
        
        session()->flash('alert', 'Berhasil menambah promosi!');
        return redirect('admin/promosi');
    }

    public function ubahpromosi($id)
    {
        $promosi = DB::table('promosi')->where('id_promosi', $id)->first();
        if (!$promosi) {
            session()->flash('error', 'Promosi tidak ditemukan');
            return redirect('admin/promosi');
        }
        
        $produk = DB::table('produk')->get();
        $selected_produk = DB::table('promosi_produk')
            ->where('id_promosi', $id)
            ->pluck('idproduk')
            ->toArray();
            
        return view('admin.promosi.ubah', compact('promosi', 'produk', 'selected_produk'));
    }

    public function updatepromosi(Request $request, $id)
    {
        $request->validate([
            'nama_promosi' => 'required',
        ]);
        
        $promosi = DB::table('promosi')->where('id_promosi', $id)->first();
        if (!$promosi) {
            session()->flash('error', 'Promosi tidak ditemukan');
            return redirect('admin/promosi');
        }
        
        $data = [
            'nama_promosi' => $request->input('nama_promosi'),
            'deskripsi' => $request->input('deskripsi'),
            'is_active' => $request->has('is_active') ? 1 : 0,
            'updated_at' => now(),
        ];
        
        if ($request->hasFile('foto')) {
            if (!empty($promosi->foto) && file_exists(public_path('foto/' . $promosi->foto))) {
                @unlink(public_path('foto/' . $promosi->foto));
            }
            
            $file = $request->file('foto');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $fotoName);
            $data['foto'] = $fotoName;
        }
        
        DB::table('promosi')->where('id_promosi', $id)->update($data);
        
        DB::table('promosi_produk')->where('id_promosi', $id)->delete();
        
        if ($request->has('produk_ids')) {
            $produk_ids = $request->input('produk_ids');
            $pivotData = [];
            foreach ($produk_ids as $idproduk) {
                $pivotData[] = [
                    'id_promosi' => $id,
                    'idproduk' => $idproduk
                ];
            }
            DB::table('promosi_produk')->insert($pivotData);
        }
        
        session()->flash('alert', 'Berhasil mengubah promosi!');
        return redirect('admin/promosi');
    }

    public function hapuspromosi($id)
    {
        $promosi = DB::table('promosi')->where('id_promosi', $id)->first();
        if ($promosi) {
            if (!empty($promosi->foto) && file_exists(public_path('foto/' . $promosi->foto))) {
                @unlink(public_path('foto/' . $promosi->foto));
            }
            DB::table('promosi')->where('id_promosi', $id)->delete();
        }
        
        session()->flash('alert', 'Berhasil menghapus promosi!');
        return redirect('admin/promosi');
    }
}
