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
        $this->checkExpiredOrders();
        $this->checkDeliveryNotification();

        $produk = DB::table('produk')->Join('kategori', 'produk.idkategori', '=', 'kategori.idkategori')->orderBy('idproduk', 'desc')->limit(6)->get();

        // Load active promotions
        $activePromotions = DB::table('promosi')
            ->where('is_active', 1)
            ->orderBy('id_promosi', 'desc')
            ->get();

        foreach ($activePromotions as $promo) {
            $promo->produk = DB::table('promosi_produk')
                ->join('produk', 'promosi_produk.idproduk', '=', 'produk.idproduk')
                ->where('promosi_produk.id_promosi', $promo->id_promosi)
                ->get();
        }

        $data = [
            'produk' => $produk,
            'activePromotions' => $activePromotions,
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
        $iduser = null;
        if (session('pengguna')) {
            $iduser = session('pengguna')->id;
        } elseif (session('admin')) {
            $iduser = session('admin')->id;
        }

        if ($iduser) {
            DB::table('notifikasi')->where('id', $iduser)->delete();
        }
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
        $kategori = DB::table('kategori')->paginate(12);

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
        // Preserve shopping cart when logging out — only remove user-related session keys
        $keranjang = session()->get('keranjang');

        // Forget authentication and reset-related keys but keep cart
        session()->forget(['pengguna', 'admin', 'reset_email', 'otp_verified']);

        if ($keranjang !== null) {
            session(['keranjang' => $keranjang]);
        }

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

        return redirect('home/akun')->with('success', 'Data akun berhasil diubah');
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

        if (empty($alamatpengirim) || trim($alamatpengirim) == '') {
            return back()->with([
                'swal_type'  => 'error',
                'swal_title' => 'Alamat Kosong',
                'swal_text'  => 'Alamat pengiriman wajib diisi. Silakan edit dan lengkapi alamat Anda.'
            ])->withInput();
        }

        if (!empty($lokasi)) {
            $addressLower = strtolower($alamatpengirim);
            $lokasiParts = explode(',', $lokasi);
            $missingParts = [];
            foreach ($lokasiParts as $part) {
                $trimmedPart = trim($part);
                if (!empty($trimmedPart) && strpos($addressLower, strtolower($trimmedPart)) === false) {
                    $missingParts[] = $trimmedPart;
                }
            }
            if (!empty($missingParts)) {
                return back()->with([
                    'swal_type'  => 'error',
                    'swal_title' => 'Alamat Belum Lengkap',
                    'swal_text'  => 'Alamat pengiriman harus mencantumkan lokasi tujuan: ' . implode(', ', $missingParts) . '.'
                ])->withInput();
            }
        }

        // Update alamat di profil pengguna agar tersimpan untuk pemesanan berikutnya
        DB::table('pengguna')->where('id', $id)->update([
            'alamat' => $alamatpengirim
        ]);

        // Perbarui session pengguna
        $penggunaTerupdate = DB::table('pengguna')->where('id', $id)->first();
        session(['pengguna' => $penggunaTerupdate]);

        $tipe = $request->input('tipe'); // DP atau Lunas
        $metode = $request->input('metodepembayaran');

        $sizes_input = $request->input('sizes', []);

        $total_m = 0;
        $total_l = 0;
        $total_xl = 0;
        $total_xxl = 0;

        $keranjang = session()->get('keranjang', []);

        // Validasi per produk
        foreach ($keranjang as $idproduk => $item) {
            $prod_m = (int) ($sizes_input[$idproduk]['m'] ?? 0);
            $prod_l = (int) ($sizes_input[$idproduk]['l'] ?? 0);
            $prod_xl = (int) ($sizes_input[$idproduk]['xl'] ?? 0);
            $prod_xxl = (int) ($sizes_input[$idproduk]['xxl'] ?? 0);

            if (($prod_m + $prod_l + $prod_xl + $prod_xxl) !== (int) $item['jumlah']) {
                return back()->with([
                    'swal_type'  => 'error',
                    'swal_title' => 'Validasi Gagal',
                    'swal_text'  => "Total rincian ukuran untuk produk '{$item['nama']}' tidak sesuai dengan kuantitas pesanan ({$item['jumlah']})."
                ])->withInput();
            }

            $total_m += $prod_m;
            $total_l += $prod_l;
            $total_xl += $prod_xl;
            $total_xxl += $prod_xxl;
        }

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
            'size_m' => $total_m,
            'size_l' => $total_l,
            'size_xl' => $total_xl,
            'size_xxl' => $total_xxl,
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
            $produk = DB::table('produk as p')
                ->leftJoin('kategori as k', 'p.idkategori', '=', 'k.idkategori')
                ->where('p.idproduk', $idproduk)
                ->select('p.*', 'k.namakategori')
                ->first();

            if (!$produk) {
                continue;
            }

            $prod_m = (int) ($sizes_input[$idproduk]['m'] ?? 0);
            $prod_l = (int) ($sizes_input[$idproduk]['l'] ?? 0);
            $prod_xl = (int) ($sizes_input[$idproduk]['xl'] ?? 0);
            $prod_xxl = (int) ($sizes_input[$idproduk]['xxl'] ?? 0);

            DB::table('pembelianproduk')->insert([
                'idpembelian' => $idpembelian,
                'idproduk' => $produk->idproduk,

                // snapshot yang sudah ada
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'subharga' => $produk->harga * $item['jumlah'],
                'jumlah' => $item['jumlah'],

                // snapshot tambahan
                'foto_produk' => $produk->foto,
                'idkategori_snapshot' => $produk->idkategori,
                'namakategori_snapshot' => $produk->namakategori,

                // ukuran detail produk
                'size_m' => $prod_m,
                'size_l' => $prod_l,
                'size_xl' => $prod_xl,
                'size_xxl' => $prod_xxl,

                'is_bonus' => 0,
            ]);

            // =============================================
            // BONUS OTOMATIS: kelipatan 12 → +2 produk
            // 1 lusin (12)  → bonus 2 | 2 lusin (24) → bonus 4, dst.
            // =============================================
            $jumlah = (int) $item['jumlah'];
            $bonusQty = (int) floor($jumlah / 12) * 2;

            if ($bonusQty > 0) {
                // Ukuran bonus awalnya diatur ke 0, akan ditentukan secara manual oleh Admin di halaman pembayaran
                DB::table('pembelianproduk')->insert([
                    'idpembelian'          => $idpembelian,
                    'idproduk'             => $produk->idproduk,
                    'nama'                 => $produk->nama,
                    'harga'                => 0,            // bonus = gratis
                    'subharga'             => 0,
                    'jumlah'               => $bonusQty,
                    'foto_produk'          => $produk->foto,
                    'idkategori_snapshot'  => $produk->idkategori,
                    'namakategori_snapshot' => $produk->namakategori,
                    'size_m'               => 0,
                    'size_l'               => 0,
                    'size_xl'              => 0,
                    'size_xxl'             => 0,
                    'is_bonus'             => 1,
                ]);
            }
        }

        // Kirim notifikasi ke Admin
        $admins = DB::table('pengguna')->where('level', 'Admin')->get();
        foreach ($admins as $admin) {
            DB::table('notifikasi')->insert([
                'id' => $admin->id,
                'pesan' => "Transaksi baru {$notransaksi} telah masuk dari {$nama}.",
                'status' => 'unread',
                'created_at' => $waktu
            ]);
        }

        // Bersihkan keranjang
        session()->forget('keranjang');

        return redirect('home/riwayat')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Pesan Produk Berhasil',
            'swal_text'  => 'Pesanan Anda berhasil diproses'
        ]);
    }

    public function riwayat(Request $request)
    {
        if (!session('pengguna')) {
            return redirect('home/login')->with([
                'swal_type'  => 'warning',
                'swal_title' => 'Akses Ditolak',
                'swal_text'  => 'Anda belum login, silakan login terlebih dahulu'
            ]);
        }

        $idpengguna = session('pengguna')->id;
        // Base query with joins
        $query = DB::table('pembelian')

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

            ->where('pembelian.id', $idpengguna);

        // Apply search by product name
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereExists(function ($q) use ($search) {
                $q->select(DB::raw(1))
                    ->from('pembelianproduk as pp')
                    ->leftJoin('produk as p', 'pp.idproduk', '=', 'p.idproduk')
                    ->whereColumn('pp.idpembelian', 'pembelian.idpembelian')
                    ->where(function ($qq) use ($search) {
                        $qq->where('pp.nama', 'like', '%' . $search . '%')
                            ->orWhere('p.nama', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('pembelian.statusbeli', $request->input('status'));
        }

        // Filter by payment method
        if ($request->filled('metode')) {
            $query->where('pembelian.metodepembayaran', $request->input('metode'));
        }

        // Sorting by transaction time
        // Sorting default: Tanggal Pesan terbaru
        $sortTime = $request->input('sort_time', 'time_desc');

        if ($sortTime == 'time_asc') {
            $query->orderBy('pembelian.tanggalbeli', 'asc')
                ->orderBy('pembelian.waktu', 'asc')
                ->orderBy('pembelian.idpembelian', 'asc');
        } else {
            $query->orderBy('pembelian.tanggalbeli', 'desc')
                ->orderBy('pembelian.waktu', 'desc')
                ->orderBy('pembelian.idpembelian', 'desc');
        }
        // Paginate and preserve filters in query string
        $databeli = $query->paginate(10)->appends($request->only(['search', 'sort_time', 'status', 'metode']));

        // Produk
        $dataproduk = [];
        foreach ($databeli as $row) {
            $produk = $this->getProdukTransaksi($row->idpembelianreal);
            $dataproduk[$row->idpembelianreal] = $produk;
        }

        // Payment methods for filter dropdown
        $paymentMethods = DB::table('pembelian')->where('id', $idpengguna)->distinct()->pluck('metodepembayaran');

        return view('home.riwayat', compact('databeli', 'dataproduk', 'paymentMethods'));
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

        $datapembelian = DB::table('pembelian')
            ->where('idpembelian', $id)
            ->where('id', session('pengguna')->id)
            ->first();

        if (!$datapembelian) {
            return redirect('home/riwayat')->with([
                'swal_type'  => 'error',
                'swal_title' => 'Data Tidak Ditemukan',
                'swal_text'  => 'Transaksi tidak ditemukan atau bukan milik akun Anda.'
            ]);
        }

        $dataproduk = $this->getProdukTransaksi($id);

        $pembayaran = DB::table('pembayaran')
            ->where('idpembelian', $id)
            ->orderBy('idpembayaran', 'asc')
            ->get();

        return view('home.invoice', [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
            'pembayaran' => $pembayaran,
        ]);
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
        // $datapembelian = DB::table('pembelian')->join('pengguna', 'pengguna.id', '=', 'pembelian.id')
        //     ->where('pembelian.idpembelian', $id)->first();
        $datapembelian = DB::table('pembelian')
            ->where('idpembelian', $id)
            ->where('id', session('pengguna')->id)
            ->first();
        $dataproduk = $this->getProdukTransaksi($id);
        $pembelianFoto = DB::table('pembelian_foto')
            ->where('id_pembelian', $id)
            ->get();

        $data = [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
            'pembelianFoto' => $pembelianFoto,
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

        $datapembelian = DB::table('pembelian')
            ->where('idpembelian', $id)
            ->where('id', session('pengguna')->id)
            ->first();

        if (!$datapembelian) {
            return redirect('home/riwayat')->with([
                'swal_type'  => 'error',
                'swal_title' => 'Data Tidak Ditemukan',
                'swal_text'  => 'Transaksi tidak ditemukan atau bukan milik akun Anda.'
            ]);
        }

        $dataproduk = $this->getProdukTransaksi($id);

        return view('home.pembayaran', [
            'datapembelian' => $datapembelian,
            'dataproduk' => $dataproduk,
        ]);
    }

    public function pembayaransimpan(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->with([
                'swal_type' => 'error',
                'swal_title' => 'Validasi Gagal',
                'swal_text' => 'File harus berupa gambar dengan ukuran maksimal 2MB.'
            ]);
        }

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

        // Kirim notifikasi ke Admin
        $waktu = date('Y-m-d H:i:s');
        $notransaksi = $datapembelian->notransaksi;
        $namaPemesan = $datapembelian->nama;
        $tipeBayar   = $datapembelian->tipepembayaran == 'DP' ? 'DP (50%)' : 'Lunas';
        $jumlahFmt   = 'Rp ' . number_format($jumlah, 0, ',', '.');

        $admins = DB::table('pengguna')->where('level', 'Admin')->get();
        foreach ($admins as $admin) {
            DB::table('notifikasi')->insert([
                'id'         => $admin->id,
                'pesan'      => "💳 Bukti pembayaran {$tipeBayar} sebesar {$jumlahFmt} telah diupload oleh {$namaPemesan} untuk transaksi {$notransaksi}.",
                'status'     => 'unread',
                'created_at' => $waktu,
            ]);
        }

        return redirect('home/riwayat')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Bukti Pembayaran Terkirim',
            'swal_text'  => 'Bukti pembayaran Anda berhasil diupload. Admin akan segera memverifikasi.',
        ]);
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
        $dataproduk = $this->getProdukTransaksi($id);

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
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->with([
                'swal_type' => 'error',
                'swal_title' => 'Validasi Gagal',
                'swal_text' => 'File harus berupa gambar dengan ukuran maksimal 2MB.'
            ]);
        }

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
            'tipepembayaran'  => 'Lunas'
        ]);

        // Kirim notifikasi ke Admin
        $waktu       = date('Y-m-d H:i:s');
        $notransaksi = $datapembelian->notransaksi;
        $namaPemesan = $datapembelian->nama;
        $jumlahFmt   = 'Rp ' . number_format($jumlahPelunasan, 0, ',', '.');

        $admins = DB::table('pengguna')->where('level', 'Admin')->get();
        foreach ($admins as $admin) {
            DB::table('notifikasi')->insert([
                'id'         => $admin->id,
                'pesan'      => "✅ Bukti pelunasan sebesar {$jumlahFmt} telah diupload oleh {$namaPemesan} untuk transaksi {$notransaksi}.",
                'status'     => 'unread',
                'created_at' => $waktu,
            ]);
        }

        return redirect('home/riwayat')->with([
            'swal_type'  => 'success',
            'swal_title' => 'Pelunasan Terkirim',
            'swal_text'  => 'Bukti pelunasan Anda berhasil diupload. Admin akan segera memverifikasi.',
        ]);
    }



    public function selesai(Request $request)
    {
        $request->validate([
            'idpembelian' => 'required',
            'foto_penerimaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'foto_penerimaan.image' => 'File harus berupa gambar.',
            'foto_penerimaan.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $idpembelian = $request->input('idpembelian');
        $catatan = $request->input('catatan');

        if ($request->hasFile('foto_penerimaan')) {
            $file = $request->file('foto_penerimaan');
            $namafoto = date('Ymdhis') . '-penerimaan-' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $namafoto);

            // Simpan foto penerimaan barang
            DB::table('pembelian_foto')->insert([
                'id_pembelian' => $idpembelian,
                'status' => 'Selesai',
                'foto' => $namafoto,
            ]);
        }

        DB::table('pembelian')->where('idpembelian', $idpembelian)->update([
            'statusbeli' => 'Selesai',
            'catatan_selesai' => $catatan,
            'updated_at' => now(),
        ]);

        // Kirim notifikasi ke admin bahwa pesanan telah diselesaikan oleh pelanggan
        $order = DB::table('pembelian')->where('idpembelian', $idpembelian)->first();
        if ($order) {
            $admins = DB::table('pengguna')->where('level', 'Admin')->get();
            foreach ($admins as $admin) {
                DB::table('notifikasi')->insert([
                    'id' => $admin->id,
                    'pesan' => "Pesanan {$order->notransaksi} telah diselesaikan oleh pelanggan.",
                    'status' => 'unread',
                    'created_at' => now()
                ]);
            }
        }

        return redirect('home/riwayat')->with([
            'swal_type' => 'success',
            'swal_title' => 'Pesanan Selesai',
            'swal_text' => 'Terima kasih, pesanan Anda telah diselesaikan.'
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
}
