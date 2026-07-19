@extends('home.templates.index')

@section('page-content')
    <style>
        .product-row-hover:hover {
            background-color: #f8f9fa;
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
            <?php if ($datapembelian->statusbeli == "Belum Bayar") { ?>
            <div>
                <div class="card text-center" style="background-color: #ffbf0f;">
                    <p style="color: white;" class="m-auto py-3">
                        {{-- <img src="{{ asset('foto/1b.png') }}" href="{{ url('home') }}" width="20"> Detail Informasi
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/2b.png') }}" href="{{ url('home') }}" width="20"> Pembayaran
                        <img src="{{ asset('foto/line.png') }}" href="{{ url('home') }}" width="20">
                        <img src="{{ asset('foto/3a.png') }}" href="{{ url('home') }}" width="20"> Konfirmasi --}}
                        Pembayaran
                    </p>
                </div>
            </div>
            <div class="mt-5">
                <h1 style="color: black; font-weight:bold;">Pembayaran</h1>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-8">
                    <?php if ($datapembelian->statusbeli == "Belum Bayar") { ?>
                    <div class="card py-2 mb-5 px-2 text-justify">
                        <h3 style="color: black;">Catatan :</h3>
                        <ul>
                            <li>Untuk pembayaran via Transfer, verifikasi pembayaran akan dilakukan saat anda sudah
                                melakukan transfer ke rekening Oldshine Konveksi.</li>
                            <li>Jangan lupa anda screenshot bukti pembayaran yang nantinya akan dilampirkan di halaman
                                konfirmasi.</li>
                        </ul>
                        <p class="text-center">Rekening Oldshine Konveksi</p>
                        <div class="card text-center" style="background-color: #000;">
                            <p style="color: #fff;" class="m-auto py-3">BANK BRI an ARYO WIRANJOYO<br> <span
                                    style="color: #43A86B; font-weight:bold; font-size:25px">015801049100509</span></p>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="card py-2 px-2 text-justify">
                        <h3 style="color: black; font-weight:bold;">Rincian Harga</h3>

                        <?php $totalbelanja = 0; ?>
                        @foreach ($dataproduk as $dp)
                            @php
                                $totalharga = $dp->harga * $dp->jumlah;
                                $firstFoto = explode(',', $dp->foto)[0] ?? 'noimage.png';
                                $isBonus = isset($dp->is_bonus) && $dp->is_bonus == 1;
                            @endphp
                            <div class="row product-row-hover {{ $isBonus ? 'bg-light border-left border-success' : '' }}"
                                style="cursor: pointer; padding: 5px 0; {{ $isBonus ? 'border-left: 3px solid #28a745 !important; padding-left: 8px;' : '' }}"
                                data-foto="{{ asset('foto/' . $firstFoto) }}" data-nama="{{ $dp->nama }}">
                                <div class="col-md-8">
                                    <p
                                        style="color: {{ $isBonus ? '#28a745' : 'black' }}; font-weight: bold; margin-bottom: 0;">
                                        {{ $dp->nama }}
                                        @if ($isBonus)
                                            <span class="badge badge-success ml-1"
                                                style="font-size:0.7rem; vertical-align: middle;">🎁 BONUS</span>
                                        @endif
                                        ({{ $dp->jumlah }} x)
                                        @if (!$isBonus)
                                            Rp {{ number_format($dp->harga) }},-
                                        @else
                                            <span class="text-success" style="font-size:0.85rem;">GRATIS</span>
                                        @endif
                                    </p>
                                    @if ($dp->size_m > 0 || $dp->size_l > 0 || $dp->size_xl > 0 || $dp->size_xxl > 0)
                                        <p style="color: #666; font-size: 0.85rem; margin-top: 2px; margin-bottom: 0;">
                                            Ukuran:
                                            @if ($dp->size_m > 0)
                                                M: {{ $dp->size_m }}
                                            @endif
                                            @if ($dp->size_l > 0)
                                                L: {{ $dp->size_l }}
                                            @endif
                                            @if ($dp->size_xl > 0)
                                                XL: {{ $dp->size_xl }}
                                            @endif
                                            @if ($dp->size_xxl > 0)
                                                XXL: {{ $dp->size_xxl }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if ($isBonus)
                                        <p class="text-right mb-0"><span class="badge badge-success">GRATIS</span></p>
                                    @else
                                        <p style="color: black; font-weight: bold; margin-bottom: 0;" class="text-right">Rp
                                            {{ number_format($totalharga) }},-</p>
                                    @endif
                                </div>
                            </div>
                            <?php $totalbelanja += $totalharga; ?>
                        @endforeach
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 style="color: black; font-weight:bold;">Ongkir</h5>
                            </div>
                            <div class="col-md-4">
                                <p style="color: black; font-weight:bold;" class="text-right">Rp
                                    {{ number_format($datapembelian->ongkir) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <h5 style="color: black; font-weight:bold;">Total</h5>
                            </div>
                            <div class="col-md-4">
                                <p style="color: black; font-weight:bold;" class="text-right">Rp
                                    {{ number_format($datapembelian->totalbeli + $datapembelian->ongkir) }} <br> <span
                                        style="color: red; font-weight:400;">NON
                                        REFUNDABLE</span></p>
                            </div>
                        </div>
                        <hr>

                        {{-- Tampilkan DP atau Lunas --}}
                        @if ($datapembelian->tipepembayaran == 'DP')
                            @php
                                $harusBayar = ($datapembelian->totalbeli + $datapembelian->ongkir) * 0.5;
                            @endphp

                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="color: black; font-weight:bold;">Total Dibayar (DP 50%)</h5>
                                </div>
                                <div class="col-md-4">
                                    <p style="color: black; font-weight:bold;" class="text-right">
                                        Rp {{ number_format($harusBayar) }}
                                    </p>
                                </div>
                            </div>

                            <p class="text-danger"><strong>Pembayaran: DP 50%</strong></p>
                        @else
                            @php
                                $harusBayar = $datapembelian->totalbeli + $datapembelian->ongkir;
                            @endphp

                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="color: black; font-weight:bold;">Total Dibayar (Lunas)</h5>
                                </div>
                                <div class="col-md-4">
                                    <p style="color: black; font-weight:bold;" class="text-right">
                                        Rp {{ number_format($harusBayar) }}
                                    </p>
                                </div>
                            </div>

                            <p class="text-success"><strong>Pembayaran: Lunas</strong></p>
                        @endif

                        <hr>
                        <p>Dengan melanjutkan ke tahapan selanjutnya, Anda telah membaca dan setuju dengan pihak
                            Oldshine Konveksi dengan <a href="#" onclick="buttonModal()"
                                idstyle="color: #ffbf0f;">Syarat &
                                Kententuannya</a>.</p>

                        <?php if ($datapembelian->statusbeli == "Belum Bayar") { ?>
                        <a class="btn btn-lg text-white" href="{{ url('home/pembayaran/' . $datapembelian->idpembelian) }}"
                            style="background-color: #ffbf0f">Lanjutkan Pembayaran</a>
                        <?php } else { ?>
                        <a class="btn btn-lg text-white mb-2"
                            href="{{ url('home/invoice/' . $datapembelian->idpembelian) }}"
                            style="background-color: #ffbf0f">Invoice</a>
                        <?php } ?>

                        @if (in_array($datapembelian->statusbeli, ['Sedang Dikirim', 'Pesanan Sedang Dikirim']))
                            <div class="card p-3 mt-4 border-warning">
                                <h5 class="text-black font-weight-bold">Selesaikan Pesanan</h5>
                                <p class="text-muted small font-weight-bold">Status Pesanan Anda Sedang Dikirim. Silakan konfirmasi terima pesanan jika barang sudah diterima.</p>
                                <button type="button" class="btn text-white w-100 font-weight-bold" onclick="openTerimaPesananModal('{{ $datapembelian->idpembelian }}')"
                                    style="background-color: #28a745; border-radius: 8px;">Terima Pesanan</button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    @include('home.partials.order-sidebar')

                    @php
                        $fotoPengiriman =
                            $pembelianFoto->where('status', 'Sedang Dikirim')->first() ??
                            $pembelianFoto->where('status', 'Pesanan Sedang Dikirim')->first();
                    @endphp

                    @if ($fotoPengiriman)
                        <div class="card mt-3 py-2 px-2 bg-light">
                            <h5 style="color: black; font-weight: bold;">Foto Pengiriman (Kurir)</h5>
                            <img src="{{ asset('foto/' . $fotoPengiriman->foto) }}" class="img-fluid rounded"
                                alt="Foto Pengiriman" style="max-height: 300px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
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
                        <p>Harga disesuaikan dengan jumlah, bahan, dan tingkat kesulitan desain. Pembayaran DP / pelunasan
                            dilakukan sesuai kesepakatan.</p>
                    </section>

                    <section>
                        <h3>Produksi & Custom Order</h3>
                        <p>Waktu produksi menyesuaikan jumlah and tingkat kesulitan. Produk bersifat custom, tidak dapat
                            dibatalkan atau direfund setelah produksi berjalan.</p>
                    </section>

                    <section>
                        <h3>Komplain</h3>
                        <p>Komplain diterima maksimal 2×24 jam setelah barang diterima dengan bukti foto/video unboxing.</p>
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

        <!-- Modal Terima Pesanan -->
        <div id="modalTerimaPesanan" class="modal-overlay" style="display: none;">
            <div class="modal-box">
                <div class="modal-header">
                    <h1 style="font-size: 1.5rem; font-weight: bold; margin: 0; color: #1a1a1a;">Konfirmasi Terima Pesanan</h1>
                    <i class="fa fa-times close-icon" onclick="toggleTerimaPesananModal()" style="cursor: pointer; font-size: 1.25rem;"></i>
                </div>
                <form action="{{ url('home/selesai') }}" method="POST">
                    @csrf
                    <div class="modal-content" style="padding: 20px;">
                        <input type="hidden" name="idpembelian" id="terimaIdPembelian" value="">
                        
                        <div class="form-group mb-0">
                            <label class="font-weight-bold text-black" style="font-size: 0.9rem; color: #333;">Catatan Penerimaan (Opsional)</label>
                            <textarea class="form-control" name="catatan" placeholder="Masukkan catatan / ulasan tentang pesanan Anda..." rows="3" style="font-size: 0.85rem; border: 1px solid #ced4da; border-radius: 6px; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 15px 24px; border-top: 1px solid #f0f0f0; display: flex; justify-content: flex-end; gap: 10px; background-color: #fcfcfc;">
                        <button type="button" class="btn btn-secondary font-weight-bold" onclick="toggleTerimaPesananModal()" style="font-size: 0.85rem; padding: 8px 16px; border-radius: 6px; border: 1px solid #ccc; background-color: #f0f0f0; color: #333; cursor: pointer; transition: background 0.2s;">Batal</button>
                        <button type="submit" class="btn text-white font-weight-bold" style="font-size: 0.85rem; padding: 8px 16px; border-radius: 6px; background-color: #28a745; border: none; cursor: pointer; transition: background 0.2s;">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        const modalContainer = document.getElementById('modalContainer');
        const totalBelanja = {{ $totalbelanja ?? 0 }};

        function openTerimaPesananModal(idpembelian) {
            document.getElementById('terimaIdPembelian').value = idpembelian;
            document.getElementById('modalTerimaPesanan').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function toggleTerimaPesananModal() {
            const modal = document.getElementById('modalTerimaPesanan');
            if (modal.style.display === 'flex') {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            } else {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

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
            // Update title
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
            if (slides.length > 1) {
                autoTimer = setInterval(() => goToSlide(currentSlide + 1), 5000);
            }
        }

        // Dot click
        dots.forEach(d => d.addEventListener('click', function() {
            goToSlide(parseInt(this.dataset.dot));
            resetAutoSlide();
        }));

        // Hover row => jump to that product's first slide
        $(document).on('mouseenter', '.product-row-hover', function() {
            const nama = $(this).data('nama');
            // find first slide matching this product name
            for (let i = 0; i < slides.length; i++) {
                if (slides[i].dataset.nama === nama) {
                    goToSlide(i);
                    resetAutoSlide();
                    break;
                }
            }
        });

        // Start auto-slide
        resetAutoSlide();
    </script>
@endsection
