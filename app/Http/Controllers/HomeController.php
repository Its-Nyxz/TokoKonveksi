<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    public function index()
    {
        $produk = DB::table('produk')->Join('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->orderBy('idproduk', 'desc')->limit(6)->get();
        $data = [
            'produk' => $produk,
        ];

        return view('home/index', $data);
    }

    public function deletenotification($id)
    {
        DB::table('notifikasi')->where('idnotifikasi', $id)->delete();
        return back();
    }

    public function bersihkannotifikasi()
    {
        $iduser = session('pengguna')->id;
        DB::table('notifikasi')->where('id', $iduser)->delete();
        return back();
    }

    public function produkdaftar()
    {
        $produk = DB::table('produk')->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->orderBy('idproduk', 'desc')->paginate(6);
        $data = [
            'produk' => $produk,
        ];
        return view('home/produk', $data);
    }

    public function artikel()
    {
        $artikel = DB::table('artikel')->orderBy('idartikel', 'desc')->paginate(6);
        $data = [
            'artikel' => $artikel,
        ];
        return view('home/artikel', $data);
    }

    public function tentang()
    {
        return view('home/tentang');
    }

    public function produkfilter(Request $request)
    {
        $query = DB::table('produk')
            ->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')
            ->select('produk.*', 'kategori.namakategori');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('produk.nama', 'like', '%' . $search . '%')
                ->orWhere('kategori.namakategori', 'like', '%' . $search . '%');
        }

        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy == 'price_asc') {
                $query->orderBy('produk.harga', 'asc');
            } elseif ($sortBy == 'price_desc') {
                $query->orderBy('produk.harga', 'desc');
            } elseif ($sortBy == 'name_asc') {
                $query->orderBy('produk.nama', 'asc');
            } elseif ($sortBy == 'name_desc') {
                $query->orderBy('produk.nama', 'desc');
            } else {
                $query->orderBy('produk.idproduk', 'desc');
            }
        } else {
            $query->orderBy('produk.idproduk', 'desc');
        }

        $produk = $query->paginate(6);

        $data = [
            'produk' => $produk,
        ];
        return view('home/produk', $data);
    }

    public function kategori()
    {
        $kategori = DB::table('kategori')->paginate(8);

        $data = [
            'kategori' => $kategori,
        ];

        return view('home.kategori', $data);
    }

    public function kategoriproduk($id)
    {
        $data['produk'] = DB::table('produk')->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->where('produk.idkategori', $id)->orderBy('idproduk', 'desc')->paginate(6);

        return view('home/kategoriproduk', $data);
    }

    public function kategorifilter(Request $request)
    {
        $query = DB::table('produk')
            ->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')
            ->select('produk.*', 'kategori.namakategori');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('produk.nama', 'like', '%' . $search . '%')
                    ->orWhere('kategori.namakategori', 'like', '%' . $search . '%');
            });
        }

        // Category filtering
        if ($request->has('category_id') && $request->input('category_id') != '') {
            $categoryId = $request->input('category_id');
            $query->where('produk.idkategori', $categoryId);
        }

        // Sorting functionality
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy == 'price_asc') {
                $query->orderBy('produk.harga', 'asc');
            } elseif ($sortBy == 'price_desc') {
                $query->orderBy('produk.harga', 'desc');
            } elseif ($sortBy == 'name_asc') {
                $query->orderBy('produk.nama', 'asc');
            } elseif ($sortBy == 'name_desc') {
                $query->orderBy('produk.nama', 'desc');
            } else {
                $query->orderBy('produk.idproduk', 'desc');
            }
        } else {
            $query->orderBy('produk.idproduk', 'desc');
        }

        $produk = $query->paginate(6);
        $allCategories = DB::table('kategori')->get(); // Fetch all categories

        $data = [
            'produk' => $produk,
            'allCategories' => $allCategories,
        ];

        return view('home.kategori', $data);
    }



    public function detail($id)
    {
        $produk = DB::table('produk')->leftJoin('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->where('idproduk', $id)->first();
        $namaLengkap = $produk->nama;
        $namaArray = explode(' ', $namaLengkap);
        $produkLainnya = DB::table('produk')
            ->where('idkategori', $produk->idkategori)
            ->where('idproduk', '!=', $id) // Kecualikan produk awal
            ->take(3)
            ->get();
        $data = [
            'produk' => $produk,
            'produkLainnya' => $produkLainnya,
        ];
        // session()->forget('keranjang');
        // dd(session('keranjang'));
        return view('home.detail', $data);
    }

    public function detailartikel($id)
    {
        $artikel = DB::table('artikel')->where('idartikel', $id)->first();
        $data = [
            'artikel' => $artikel,
        ];
        return view('home.detailartikel', $data);
    }

    public function daftar()
    {
        return view('home.daftar');
    }

    public function dodaftar(Request $request)
    {
        $request->validate([
            'nama'                 => 'required|string|max:255',
            'email'                => 'required|email|unique:pengguna,email',
            'password'             => 'required|min:6|confirmed',
            'telepon'              => 'required',
            'jekel'                => 'required',
            'tgl_lahir'            => 'required|date',
            'tempat_lahir'         => 'required',
        ], [
            'nama.required'        => 'Nama wajib diisi',
            'email.required'       => 'Email wajib diisi',
            'email.email'          => 'Format email tidak valid',
            'email.unique'         => 'Email sudah terdaftar',
            'password.required'    => 'Password wajib diisi',
            'password.min'         => 'Password minimal 6 karakter',
            'password.confirmed'   => 'Konfirmasi password tidak sama',
            'telepon.required'     => 'No. telepon wajib diisi',
            'jekel.required'       => 'Jenis kelamin wajib dipilih',
            'tgl_lahir.required'   => 'Tanggal lahir wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
        ]);

        DB::table('pengguna')->insert([
            'nama'          => $request->nama,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'telepon'       => $request->telepon,
            'jekel'         => $request->jekel,
            'tgl_lahir'     => $request->tgl_lahir,
            'tempat_lahir'  => $request->tempat_lahir,
            'fotoprofil'    => 'Untitled.png',
            'level'         => 'Pelanggan'
        ]);

        return redirect('home/login')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Registrasi Berhasil',
            'swal_text'  => 'Silakan login menggunakan akun Anda'
        ]);
    }

    public function login()
    {
        return view('home.login');
    }

    public function dologin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $akun = DB::table('pengguna')
            ->where('email', $email)
            ->first();

        // EMAIL TIDAK DITEMUKAN
        if (!$akun) {
            return back()->with([
                'swal_type'  => 'error',
                'swal_title' => 'Login Gagal',
                'swal_text'  => 'Email tidak ditemukan'
            ]);
        }

        // PASSWORD SALAH
        if (!Hash::check($password, $akun->password)) {
            return back()->with([
                'swal_type'  => 'error',
                'swal_title' => 'Login Gagal',
                'swal_text'  => 'Password salah'
            ]);
        }

        // LOGIN BERHASIL - PELANGGAN
        if ($akun->level === 'Pelanggan') {
            session(['pengguna' => $akun]);

            return redirect('home')->with([
                'swal_type'  => 'success',
                'swal_title' => 'Login Berhasil',
                'swal_text'  => 'Selamat datang kembali'
            ]);
        }

        // LOGIN BERHASIL - ADMIN
        if ($akun->level === 'Admin') {
            session(['admin' => $akun]);

            return redirect('admin')->with([
                'swal_type'  => 'success',
                'swal_title' => 'Login Berhasil',
                'swal_text'  => 'Selamat datang kembali'
            ]);
        }

        // ROLE TIDAK VALID
        return back()->with([
            'swal_type'  => 'error',
            'swal_title' => 'Akses Ditolak',
            'swal_text'  => 'Role tidak diizinkan'
        ]);
    }

    public function lupaPassword()
    {
        return view('home.lupa-password');
    }

    public function kirimOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = DB::table('pengguna')->where('email', $request->email)->first();

        if (!$user) {
            return back()->with([
                'swal_type' => 'error',
                'swal_title' => 'Gagal',
                'swal_text' => 'Email tidak terdaftar'
            ]);
        }

        $otp = rand(100000, 999999);

        DB::table('pengguna')->where('id', $user->id)->update([
            'otp_code' => $otp,
            'otp_expired_at' => Carbon::now()->addMinutes(5)
        ]);

        Mail::raw("Kode OTP Anda: $otp\nBerlaku 5 menit.", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Kode OTP Reset Password');
        });

        session(['reset_email' => $user->email]);

        return redirect('home/verifikasi-otp')->with([
            'swal_type' => 'success',
            'swal_title' => 'OTP Terkirim',
            'swal_text' => 'Silakan cek email Anda'
        ]);
    }

    public function formOtp()
    {
        return view('home.verifikasi-otp');
    }

    public function verifikasiOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $email = session('reset_email');

        $user = DB::table('pengguna')
            ->where('email', $email)
            ->where('otp_code', $request->otp)
            ->where('otp_expired_at', '>=', now())
            ->first();

        if (!$user) {
            return back()->with([
                'swal_type' => 'error',
                'swal_title' => 'OTP Salah',
                'swal_text' => 'OTP tidak valid atau kadaluarsa'
            ]);
        }

        if (!session('reset_email')) {
            return redirect('home/lupa-password')->with([
                'swal_type' => 'error',
                'swal_title' => 'Sesi Habis',
                'swal_text' => 'Silakan ulangi proses reset password'
            ]);
        }

        session(['otp_verified' => true]);

        return redirect('home/reset-password')->with([
            'swal_type' => 'success',
            'swal_title' => 'OTP Valid',
            'swal_text' => 'Silakan buat password baru'
        ]);
    }

    public function resendOtp()
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect('home/lupa-password');
        }

        $otp = rand(100000, 999999);

        DB::table('pengguna')->where('email', $email)->update([
            'otp_code' => $otp,
            'otp_expired_at' => now()->addMinutes(5)
        ]);

        Mail::raw("Kode OTP baru Anda: $otp", function ($msg) use ($email) {
            $msg->to($email)->subject('OTP Reset Password');
        });

        return back()->with([
            'swal_type' => 'success',
            'swal_title' => 'OTP Dikirim Ulang',
            'swal_text' => 'Silakan cek email Anda'
        ]);
    }


    public function formResetPassword()
    {
        if (!session('otp_verified')) {
            return redirect('home/login');
        }

        return view('home.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required'  => 'Password wajib diisi',
            'password.min'       => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',
        ]);

        $email = session('reset_email');

        DB::table('pengguna')->where('email', $email)->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'otp_expired_at' => null
        ]);

        session()->forget(['reset_email', 'otp_verified']);

        return redirect('home/login')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Berhasil',
            'swal_text'  => 'Password berhasil diubah, silakan login'
        ]);
    }

    public function logout()
    {
        session()->flush();

        return redirect('home')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Logout Berhasil',
            'swal_text'  => 'Anda telah keluar dari akun'
        ]);
    }

    public function akun()
    {
        if (!session('pengguna')) {

            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }

        $idpengguna = session('pengguna')->id;
        $pengguna = DB::table('pengguna')->where('id', $idpengguna)->first();

        $data = [
            'pengguna' => $pengguna,
        ];
        return view('home.akun', $data);
    }

    public function ubahakun(Request $request, $id)
    {
        $password = $request->input('password');
        if (empty($password)) {
            $password = $request->input('passwordlama');
        }
        DB::table('pengguna')
            ->where('id', $id)
            ->update([
                'password' => $password,
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'telepon' => $request->input('telepon'),
                'alamat' => $request->input('alamat'),
                'jekel' => $request->input('jekel'),
                'tgl_lahir' => $request->input('tgl_lahir'),
                'tempat_lahir' => $request->input('tempat_lahir'),
                'provinsi' => $request->input('provinsi'),
                'kota' => $request->input('kota'),
                'kec' => $request->input('kec'),
                'kode_pos' => $request->input('kode_pos'),
            ]);

        return redirect('home/akun')->with('success','Data akun berhasil diubah');
    }

    public function pesan(Request $request)
    {
        if (!session('pengguna')) {
            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }

        $idproduk = $request->input('idproduk');
        $jumlah = (int) $request->input('jumlah');

        // Ambil informasi produk dari database
        $produk = DB::table('produk')->where('idproduk', $idproduk)->first();

        if (!$produk) {
            return back()->with([
                'swal_type'  => 'error',
                'swal_title' => 'Gagal',
                'swal_text'  => 'Produk tidak ditemukan'
            ]);
        }

        $keranjang = session()->get('keranjang', []);
        $jumlahTotal = $jumlah;

        if (isset($keranjang[$idproduk])) {
            $jumlahTotal += $keranjang[$idproduk]['jumlah'];
        }

        if ($jumlahTotal > $produk->stok) {
            return back()->with([
                'swal_type'  => 'error',
                'swal_title' => 'Gagal',
                'swal_text'  => 'Jumlah yang diminta melebihi stok yang tersedia.'
            ]);
        }

        if (isset($keranjang[$idproduk])) {
            $keranjang[$idproduk]['jumlah'] += $jumlah;
        } else {
            $keranjang[$idproduk] = [
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'foto' => $produk->foto,
                'jumlah' => $jumlah,
            ];
        }

        session(['keranjang' => $keranjang]);
        return redirect('home/keranjang')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Berhasil',
            'swal_text'  => 'Produk berhasil ditambahkan ke keranjang'
        ]);
    }


    public function keranjang()
    {
        if (!session('pengguna')) {
            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }

        $keranjang = session()->get('keranjang', []);

        // Ambil semua produk dari database berdasarkan idproduk yang ada di keranjang
        $produkIds = array_keys($keranjang);
        $produks = DB::table('produk')->whereIn('idproduk', $produkIds)->get()->keyBy('idproduk');

        // dd($keranjang);
        return view('home.keranjang', [
            'keranjang' => $keranjang,
            'produks' => $produks
        ]);
    }



    public function hapuskeranjang($id)
    {
        $keranjang = session()->get('keranjang');

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session(['keranjang' => $keranjang]);
        }
        return redirect('home/keranjang');
    }

    public function checkout()
    {
        if (!session('pengguna')) {

            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }
        $keranjang = session()->get('keranjang');
        $data['keranjang'] = $keranjang;


        $caripengguna = session('pengguna')->id;
        $pengguna = DB::table('pengguna')->where('id', $caripengguna)->first();
        $data['pengguna'] = $pengguna;
        return view('home.checkout', $data);
    }

    // Ambil Daftar Provinsi
    public function getlokasi(Request $request)
    {
        $keyword = $request->keyword;

        $response = Http::withHeaders([
            'key' => '7ff8406f12c653758df1a5fa6d6bf474',
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
            'search' => $keyword,
            'limit' => 100,
            'offset' => 0,
        ]);

        if ($response->successful()) {
            return response()->json($response['data']);
        } else {
            return response()->json([
                'message' => 'Gagal mencari lokasi',
                'status' => $response->status(),
                'error' => $response->body()
            ], $response->status());
        }
    }

    // GET SERVICE / ONGKIR
    public function getservices(Request $request)
    {
        $origin = 63055; // ID asal pengiriman, ganti sesuai lokasi toko kamu
        $destination = $request->destination_id; // ID tujuan (dipilih user)
        $weight = 1000; // Dalam gram
        $courier = $request->courier;
        $price = 'lowest';

        $response = Http::asForm()->withHeaders([
            'key' => '7ff8406f12c653758df1a5fa6d6bf474',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
            'price' => $price,
        ]);

        if ($response->successful()) {
            return response()->json($response->json('data'));
        } else {
            return response()->json([
                'message' => 'Gagal mengambil layanan ongkir',
                'status' => $response->status(),
                'error' => $response->body(),
            ], $response->status());
        }
    }

    public function docheckout(Request $request)
    {
        $notransaksi = '#TP' . date("Ymdhis");
        $id = session('pengguna')->id;
        $tanggalbeli = date("Y-m-d");
        $waktu = date("Y-m-d H:i:s");

        $totalbeli = $request->input('total_belanja');
        $ongkir = $request->input('ongkir') ?? 0;
     
        $nama = $request->input('nama');
        $telepon = $request->input('telepon');
        $email = $request->input('email');
        $alamatpengirim = $request->input('alamat');
        $catatanpembeli = $request->input('catatan_pembeli');

        $lokasi = $request->input('destination_id');
        $tipe = $request->input('tipe'); // DP atau Lunas
        $metode = $request->input('metodepembayaran');

        // Status awal tetap belum bayar
        $status = "Belum Bayar";

        // Simpan ke tabel pembelian
        DB::table('pembelian')->insert([
            'notransaksi' => $notransaksi,
            'id' => $id,
            'tanggalbeli' => $tanggalbeli,
            'nama' => $nama,
            'email' => $email,
            'telepon' => $telepon,
            'totalbeli' => $totalbeli,
            'catatan_pembeli' => $catatanpembeli,
            'alamat' => $alamatpengirim,
            'statusbeli' => $status,
            'lokasi' => $lokasi,
            'ongkir' => $ongkir,
            'waktu' => $waktu,
            'metodepembayaran' => $metode,
            'tipepembayaran' => $tipe,
        ]);

        // Ambil ID pembelian
        $idpembelian = DB::getPdo()->lastInsertId();

        // Buat QR Code
        $urlDetail = url('detailtransaksiqr/' . $idpembelian);
        $filename = 'qr_' . $idpembelian . '.svg';
        QrCode::format('svg')->generate($urlDetail, public_path('qr/' . $filename));

        DB::table('pembelian')->where('idpembelian', $idpembelian)->update([
            'qrcode' => $filename
        ]);

        // Simpan detail produk
        $keranjang = session()->get('keranjang');
        foreach ($keranjang as $idproduk => $item) {
            $produk = DB::table('produk')->where('idproduk', $idproduk)->first();

            DB::table('pembelianproduk')->insert([
                'idpembelian' => $idpembelian,
                'idproduk' => $produk->idproduk,
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'subharga' => $produk->harga * $item['jumlah'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        // Bersihkan keranjang
        session()->forget('keranjang');

        return redirect('home/riwayat')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Checkout Berhasil',
            'swal_text'  => 'Pesanan Anda berhasil diproses'
        ]);
    }

    public function riwayat()
    {
        if (!session('pengguna')) {
            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }

        $idpengguna = session('pengguna')->id;

        $databeli = DB::table('pembelian')

            // Subquery bukti DP
            ->leftJoin(
                DB::raw("(SELECT idpembelian, bukti AS bukti_dp
                            FROM pembayaran
                            WHERE tipe = 'DP') as dp"),
                'dp.idpembelian',
                '=',
                'pembelian.idpembelian'
            )

            // Subquery bukti Lunas
            ->leftJoin(
                DB::raw("(SELECT idpembelian, bukti AS bukti_lunas
                            FROM pembayaran
                            WHERE tipe = 'Lunas') as lunas"),
                'lunas.idpembelian',
                '=',
                'pembelian.idpembelian'
            )

            ->select(
                'pembelian.*',
                'pembelian.idpembelian as idpembelianreal',
                'dp.bukti_dp',
                'lunas.bukti_lunas'
            )

            ->where('pembelian.id', $idpengguna)
            ->orderBy('pembelian.tanggalbeli', 'desc')
            ->paginate(10);

        // Produk
        $dataproduk = [];
        foreach ($databeli as $row) {
            $produk = DB::table('pembelianproduk')
                ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
                ->where('idpembelian', $row->idpembelianreal)
                ->get();
            $dataproduk[$row->idpembelianreal] = $produk;
        }

        return view('home.riwayat', compact('databeli', 'dataproduk'));
    }


    public function detailtransaksiqr($id)
    {
        $pembelian = DB::table('pembelian')->where('idpembelian', $id)->first();
        $produk = DB::table('pembelianproduk')->where('idpembelian', $id)->get();

        if (!$pembelian) {
            abort(404);
        }

        return view('home.detailtransaksiqr', compact('pembelian', 'produk'));
    }

    public function invoice($id)
    {
        if (!session('pengguna')) {

            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }
        $datapembelian = DB::table('pembelian')->where('pembelian.idpembelian', $id)->first();
        $dataproduk = DB::table('pembelianproduk')
            ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
            ->where('idpembelian', $id)
            ->get();

        $data = [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
        ];

        return view('home.invoice', $data);
    }

    public function detailtransaksi($id)
    {
        if (!session('pengguna')) {

            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }
        $datapembelian = DB::table('pembelian')->join('pengguna', 'pengguna.id', '=', 'pembelian.id')
            ->where('pembelian.idpembelian', $id)->first();
        $dataproduk = DB::table('pembelianproduk')
            ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
            ->where('idpembelian', $id)
            ->get();

        $data = [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
        ];

        return view('home.detailtransaksi', $data);
    }

    public function pembayaran($id)
    {
        if (!session('pengguna')) {

            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }
        $datapembelian = DB::table('pembelian')->join('pengguna', 'pengguna.id', '=', 'pembelian.id')
            ->where('pembelian.idpembelian', $id)->first();
        $dataproduk = DB::table('pembelianproduk')
            ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
            ->where('idpembelian', $id)
            ->get();

        $data = [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
        ];

        return view('home.pembayaran', $data);
    }

    public function pembayaransimpan(Request $request)
    {
        $namabukti = $request->file('bukti')->getClientOriginalName();
        $namafix = date("YmdHis") . $namabukti;
        $request->file('bukti')->move('foto', $namafix);

        $idpembelian     = $request->input('idpembelian');
        $nama            = $request->input('nama');
        $tanggaltransfer = $request->input('tanggaltransfer');
        $tanggal         = date("Y-m-d");

        // Ambil data pembelian
        $datapembelian = DB::table('pembelian')->where('idpembelian', $idpembelian)->first();

        // Hitung jumlah yang dibayar
        if ($datapembelian->tipepembayaran == "DP") {
            // 50% dari total (tanpa ongkir atau dengan ongkir? — pilih salah satu)
            $jumlah = ($datapembelian->totalbeli + $datapembelian->ongkir) * 0.5;
            $status = "Sudah Upload Bukti Pembayaran DP";
        } else {
            $jumlah = $datapembelian->totalbeli + $datapembelian->ongkir;
            $status = "Sudah Upload Bukti Pembayaran";
        }

        // Simpan ke tabel pembayaran
        DB::table('pembayaran')->insert([
            'idpembelian'    => $idpembelian,
            'nama'           => $nama,
            'tanggaltransfer' => $tanggaltransfer,
            'tanggal'        => $tanggal,
            'bukti'          => $namafix,
            'jumlah'         => $jumlah,
            'tipe'           => $datapembelian->tipepembayaran,
        ]);

        // Update tabel pembelian
        DB::table('pembelian')->where('idpembelian', $idpembelian)->update([
            'statusbeli'      => $status,
            'tipepembayaran'  => $datapembelian->tipepembayaran
        ]);

        return redirect('home/riwayat')->with('alert', 'Terima kasih');
    }
    public function pelunasan($id)
    {
        if (!session('pengguna')) {
            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }

        // DATA PEMBELIAN
        $datapembelian = DB::table('pembelian')
            ->join('pengguna', 'pengguna.id', '=', 'pembelian.id')
            ->where('pembelian.idpembelian', $id)
            ->first();

        // DATA PRODUK DALAM PEMBELIAN
        $dataproduk = DB::table('pembelianproduk')
            ->join('produk', 'pembelianproduk.idproduk', '=', 'produk.idproduk')
            ->where('idpembelian', $id)
            ->get();

        // HITUNG TOTAL DP YANG SUDAH PERNAH DIBAYAR
        $totalDP = DB::table('pembayaran')
            ->where('idpembelian', $id)
            ->where('tipe', 'DP') // tipe DP
            ->sum('jumlah');

        // HITUNG TOTAL BIAYA KESELURUHAN (produk + ongkir)
        $totalKeseluruhan = $datapembelian->totalbeli + $datapembelian->ongkir;

        // HITUNG SISA PELUNASAN
        $sisaPelunasan = $totalKeseluruhan - $totalDP;

        // KIRIM KE VIEW
        return view('home.pelunasan', [
            'datapembelian'    => $datapembelian,
            'dataproduk'       => $dataproduk,
            'totalDP'          => $totalDP,
            'totalKeseluruhan' => $totalKeseluruhan,
            'sisaPelunasan'    => $sisaPelunasan,
        ]);
    }


    public function pelunasansimpan(Request $request)
    {
        // Upload bukti
        $namabukti = $request->file('bukti')->getClientOriginalName();
        $namafix = date("YmdHis") . $namabukti;
        $request->file('bukti')->move('foto', $namafix);

        $idpembelian     = $request->input('idpembelian');
        $nama            = $request->input('nama');
        $tanggaltransfer = $request->input('tanggaltransfer');
        $tanggal         = date("Y-m-d");

        // Ambil data pembelian
        $datapembelian = DB::table('pembelian')->where('idpembelian', $idpembelian)->first();

        // Ambil total DP yang sudah dibayar
        $dp = DB::table('pembayaran')
            ->where('idpembelian', $idpembelian)
            ->where('tipe', 'DP')
            ->sum('jumlah'); // kalau ada lebih dari 1 DP pun tetap aman

        // Total yang harus dibayar
        $totalKeseluruhan = $datapembelian->totalbeli + $datapembelian->ongkir;

        // Sisa pelunasan
        $jumlahPelunasan = $totalKeseluruhan - $dp;

        if ($jumlahPelunasan < 0) {
            $jumlahPelunasan = 0; // fallback kalau ada data anomali
        }

        // Simpan ke tabel pembayaran sebagai pelunasan
        DB::table('pembayaran')->insert([
            'idpembelian'     => $idpembelian,
            'nama'            => $nama,
            'tanggaltransfer' => $tanggaltransfer,
            'tanggal'         => $tanggal,
            'bukti'           => $namafix,
            'jumlah'          => $jumlahPelunasan,
            'tipe'            => 'Lunas',
        ]);

        // Update status pembelian
        DB::table('pembelian')->where('idpembelian', $idpembelian)->update([
            // 'statusbeli'      => 'Sudah Upload Bukti Pelunasan',
            'tipepembayaran'  => 'Lunas'
        ]);

        return redirect('home/riwayat')->with('alert', 'Terima kasih, pelunasan berhasil diupload.');
    }



    public function selesai(Request $request)
    {
        $idpembelian = $request->input('idpembelian');
        DB::table('pembelian')->where('idpembelian', $idpembelian)->update([
            'statusbeli' => 'Selesai'
        ]);
        return redirect('home/riwayat');
    }
}
