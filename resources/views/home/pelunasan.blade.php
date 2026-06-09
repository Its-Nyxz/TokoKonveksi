@extends('home.templates.index')

@section('page-content')
    <style>
        .product-row-hover:hover {
            background-color: #f8f9fa !important;
            border-radius: 8px;
            transition: background-color 0.2s ease;
        }

        /* Container Utama untuk Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.4);
            /* Warna hitam transparan */

            /* Efek Blur Latar Belakang */
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);

            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Box Modal */
        .modal-box {
            background-color: #ffffff;
            width: 100%;
            max-width: 600px;
            /* Lebar ideal untuk modal */
            max-height: 80vh;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fade 0.5s ease-in-out;
        }

        /* Header Modal */
        .modal-header {
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .modal-header h1 {
            font-size: 1.7rem;
            font-weight: 700;
            margin: 0;
            color: #1a1a1a;
        }

        .close-icon {
            cursor: pointer;
            color: #999;
            transition: color 0.2s;
        }

        .close-icon:hover {
            color: #ff4d4d;
        }

        /* Konten / Isi Modal */
        .modal-content {
            padding: 24px;
            overflow-y: auto;
            /* Scroll jika teks terlalu panjang */
            line-height: 1.6;
            color: #444;
        }

        .modal-content h3 {
            font-size: 1rem;
            margin-bottom: 8px;
            color: #000;
        }

        .modal-content p {
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        /* Footer Modal */
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: flex-end;
            background-color: #fcfcfc;
        }

        .confirm-btn {
            background-color: #ffbf0f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .confirm-btn:hover {
            background-color: #bb8d0f;
        }

        /* Styling Scrollbar (Opsional agar lebih rapi) */
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: #e0e0e0;
            border-radius: 10px;
        }

        @keyframes fade {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <section id="home-section" class="ftco-section">
        <div class="container mt-4">
            <div>
                <div class="card text-center" style="background-color: #ffbf0f;">
                    <p style="color: white;" class="m-auto py-3">
                        {{-- <img src="{{ asset('foto/1b.png') }}" href="{{ url('home') }}" width="20"> Detail Informasi
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/2b.png') }}" href="{{ url('home') }}" width="20"> Pembayaran
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/3a.png') }}" href="{{ url('home') }}" width="20"> Konfirmasi --}}
                        Pelunasan
                    </p>
                </div>
            </div>
            <div class="mt-5">
                <h1 style="color: black; font-weight:bold;">Pelunasan</h1>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{ url('home/pelunasansimpan') }}">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card py-2 mb-5 px-2 text-justify">
                            <input type="hidden" value="{{ $datapembelian->idpembelian }}" name="idpembelian">
                            <div class="form-group">
                                <label>Nama Rekening</label>
                                <input type="text" name="nama" class="form-control"
                                    value="{{ session('pengguna')->nama }}" required>

                            </div>
                            <div class="form-group">
                                <label>Tanggal Transfer</label>
                                <input type="date" name="tanggaltransfer" class="form-control"
                                    value="<?= date('Y-m-d') ?>" required>

                            </div>
                            <div class="form-group">
                                <label>Foto Bukti</label>
                                <input type="file" name="bukti" class="form-control" accept="image/*" required
                                    onchange="validateFile(this)">
                                <small id="fileError" class="text-danger mt-2"
                                    style="display:none; font-weight: bold;"></small>
                            </div>
                        </div>
                        <div class="card py-2 px-2 text-justify">
                            <h3 style="color: black; font-weight:bold;">Jumlah Pesanan</h3>

                            <?php $totalbelanja = 0; ?>
                            @foreach ($dataproduk as $dp)
                                @php
                                    $totalharga = $dp->harga * $dp->jumlah;
                                    $firstFoto = 'noimage.png';
                                    if (!empty($dp->foto)) {
                                        $firstFoto = explode(',', $dp->foto)[0];
                                    }
                                    $isBonus = isset($dp->is_bonus) && $dp->is_bonus == 1;
                                @endphp
                                <div class="row product-row-hover {{ $isBonus ? 'bg-light' : '' }}"
                                    style="cursor: pointer; padding: 5px 0; margin-bottom: 5px; {{ $isBonus ? 'border-left: 3px solid #28a745; padding-left: 8px;' : '' }}"
                                    data-foto="{{ asset('foto/' . $firstFoto) }}" data-nama="{{ $dp->nama }}">
                                    <div class="col-md-8">
                                        <p
                                            style="color: {{ $isBonus ? '#28a745' : 'black' }}; font-weight: bold; margin-bottom: 0;">
                                            {{ $dp->nama }}
                                            @if ($isBonus)
                                                <span class="badge badge-success ml-1" style="font-size:0.7rem;">🎁
                                                    BONUS</span>
                                            @endif
                                            ({{ $dp->jumlah }} x)
                                            @if (!$isBonus)
                                                Rp {{ number_format($dp->harga) }},-
                                            @else
                                                <span class="text-success" style="font-size:0.85rem;">GRATIS</span>
                                            @endif
                                        </p>
                                        @if ($dp->size_m > 0 || $dp->size_l > 0 || $dp->size_xl > 0 || $dp->size_xxl > 0)
                                            <p style="color:#666; font-size:0.85rem; margin:2px 0 0;">
                                                Ukuran:
                                                @if ($dp->size_m > 0)
                                                    M:{{ $dp->size_m }}
                                                @endif
                                                @if ($dp->size_l > 0)
                                                    L:{{ $dp->size_l }}
                                                @endif
                                                @if ($dp->size_xl > 0)
                                                    XL:{{ $dp->size_xl }}
                                                @endif
                                                @if ($dp->size_xxl > 0)
                                                    XXL:{{ $dp->size_xxl }}
                                                @endif
                                            </p>
                                        @endif
                                        @if ($isBonus)
                                            <br>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        @if ($isBonus)
                                            <p class="text-right mb-0"><span class="badge badge-success">GRATIS</span></p>
                                        @else
                                            <p style="color: black; font-weight: bold; margin-bottom: 0;"
                                                class="text-right">Rp {{ number_format($totalharga) }},-</p>
                                        @endif
                                    </div>
                                </div>

                                <?php $totalbelanja += $totalharga; ?>
                            @endforeach
                            <div class="row">
                                <div class="col-md-8">
                                    <p style="color: black;">Ongkir,-</p>
                                </div>
                                <div class="col-md-4">
                                    <p style="color: black;font-weight: bold;" class="text-right">Rp
                                        {{ number_format($datapembelian->ongkir) }},-</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="color: black; font-weight:bold;">Total</h5>
                                </div>
                                <div class="col-md-4">
                                    <p style="color: black; font-weight:bold;" class="text-right">Rp
                                        {{ number_format($totalbelanja + $datapembelian->ongkir) }} <br> <span
                                            style="color: red; font-weight:400;">NON REFUNDABLE</span></p>
                                </div>
                            </div>
                            {{-- TOTAL KESELURUHAN --}}
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="color: black; font-weight:bold;">Total Biaya</h5>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-right" style="color: black; font-weight:bold;">
                                        Rp {{ number_format($totalKeseluruhan) }}
                                    </p>
                                </div>
                            </div>

                            {{-- TOTAL DP YANG SUDAH DIBAYAR --}}
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="color: black; font-weight:bold;">DP yang Sudah Dibayar</h5>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-right" style="color: black; font-weight:bold;">
                                        Rp {{ number_format($totalDP) }}
                                    </p>
                                </div>
                            </div>

                            {{-- SISA PELUNASAN --}}
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="color: black; font-weight:bold;">Sisa Pelunasan</h5>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-right" style="color: red; font-weight:bold;">
                                        Rp {{ number_format($sisaPelunasan) }}
                                    </p>
                                </div>
                            </div>

                            <hr>
                            <p class="text-warning"><strong>Pembayaran: Pelunasan</strong></p>

                            <hr>
                            <p>Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak
                                Oldshine Konveksi dengan <a href="#" onclick="buttonModal()"
                                    idstyle="color: #ffbf0f;">Syarat &
                                    Kententuannya</a>.</p>

                            <button class="btn btn-lg text-white" style="background-color: #ffbf0f"
                                name="kirim">Kirimkan</button>
                        </div>{{-- /card Jumlah Pesanan --}}
                    </div>{{-- /col-md-8 --}}

                    {{-- ===== PANEL KANAN ===== --}}
                    <div class="col-md-4">
                        @include('home.partials.order-sidebar')
                    </div>
                </div>{{-- /row --}}
            </form>

            <div id="modalContainer" class="modal-overlay">
                <div class="modal-box">
                    <div class="modal-header">
                        <h1>Syarat & Ketentuan</h1>
                        <i class="fa-solid fa-xmark close-icon" onclick="buttonModal()"></i>
                    </div>

                    <div class="modal-content">
                        <section>
                            <h3>Pemesanan</h3>
                            <p>Pemesanan dilakukan melalui website, marketplace, atau kontak resmi kami. Data pesanan (jenis
                                produk, jumlah, ukuran, desain) wajib diisi dengan benar.</p>
                        </section>

                        <section>
                            <h3>Harga & Pembayaran</h3>
                            <p>Harga disesuaikan dengan jumlah, bahan, dan tingkat kesulitan desain. Pembayaran DP /
                                pelunasan
                                dilakukan sesuai kesepakatan.</p>
                        </section>

                        <section>
                            <h3>Produksi & Custom Order</h3>
                            <p>Waktu produksi menyesuaikan jumlah dan tingkat kesulitan. Produk bersifat custom, tidak dapat
                                dibatalkan atau direfund setelah produksi berjalan.</p>
                        </section>

                        <section>
                            <h3>Komplain</h3>
                            <p>Komplain diterima maksimal 2×24 jam setelah barang diterima dengan bukti foto/video unboxing.
                            </p>
                        </section>

                        <section>
                            <h3>Pesanan Ditolak</h3>
                            <p>Pesanan akan ditolak oleh admin apabila dalam waktu 1×24 jam setelah pemesanan tidak terdapat
                                bukti pembayaran yang valid. Pastikan bukti pembayaran telah diunggah atau dikirim sesuai
                                ketentuan agar pesanan dapat diproses.</p>
                        </section>
                    </div>

                    <div class="modal-footer">
                        <button onclick="buttonModal()" class="confirm-btn">Saya Mengerti</button>
                    </div>
                </div>
            </div>
    </section>

    <script>
        function validateFile(input) {
            const fileError = document.getElementById('fileError');
            const submitBtn = document.querySelector('button[name="kirim"]');
            const file = input.files[0];

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    fileError.textContent = 'Ukuran file maksimal 2MB.';
                    fileError.style.display = 'block';
                    submitBtn.disabled = true;
                    input.value = ''; // clear input
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    fileError.textContent = 'File harus berupa gambar (JPG, PNG, dll).';
                    fileError.style.display = 'block';
                    submitBtn.disabled = true;
                    input.value = ''; // clear input
                    return;
                }

                fileError.style.display = 'none';
                submitBtn.disabled = false;
            } else {
                fileError.style.display = 'none';
                submitBtn.disabled = false;
            }
        }

        const modalContainer = document.getElementById('modalContainer');
        const totalBelanja = {{ $totalbelanja ?? 0 }};

        function buttonModal() {
            if (modalContainer.style.display === 'flex') {
                modalContainer.style.display = 'none';
            } else {
                modalContainer.style.display = 'flex';
            }
        }

        // ============ SLIDESHOW LOGIC ============
        let currentSlide = 0;
        const slides = document.querySelectorAll('.product-slide');
        const dots = document.querySelectorAll('.slide-dot');
        let autoTimer = null;

        function goToSlide(idx) {
            if (!slides.length) return;
            slides[currentSlide].style.opacity = '0';
            if (dots[currentSlide]) dots[currentSlide].style.background = 'rgba(255,255,255,0.6)';
            currentSlide = (idx + slides.length) % slides.length;
            slides[currentSlide].style.opacity = '1';
            if (dots[currentSlide]) dots[currentSlide].style.background = '#ffbf0f';
            const nama = slides[currentSlide].dataset.nama;
            const titleEl = document.getElementById('previewProductTitle');
            if (titleEl && nama) titleEl.textContent = nama;
        }

        function slideMove(dir) {
            goToSlide(currentSlide + dir);
            resetAutoSlide();
        }

        function resetAutoSlide() {
            if (autoTimer) clearInterval(autoTimer);
            if (slides.length > 1) autoTimer = setInterval(() => goToSlide(currentSlide + 1), 5000);
        }

        dots.forEach(d => d.addEventListener('click', function() {
            goToSlide(parseInt(this.dataset.dot));
            resetAutoSlide();
        }));

        $(document).on('mouseenter', '.product-row-hover', function() {
            const nama = $(this).data('nama');
            for (let i = 0; i < slides.length; i++) {
                if (slides[i].dataset.nama === nama) {
                    goToSlide(i);
                    resetAutoSlide();
                    break;
                }
            }
        });

        resetAutoSlide();
    </script>
@endsection
