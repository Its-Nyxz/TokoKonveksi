@extends('home.templates.index')

@php
    $settings = DB::table('settings')->pluck('value', 'key');
@endphp

@section('page-content')

    <head>
        <!-- Include Font Awesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <style>
        .ftco-intro {
            background-color: #ffbf0f;
        }

        .intro {
            background-color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .intro .icon {
            font-size: 90px;
            color: #ffbf0f;
            margin-bottom: 0px;
        }

        .intro .text {
            color: black;
        }

        .intro h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .intro p {
            font-size: 14px;
            margin: 0;
        }

        .best-product .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .best-product .product-card img {
            border-radius: 10px;
            margin-bottom: 10px;
            max-height: 200px;
            object-fit: cover;
        }

        .best-product .product-card h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .best-product .product-card .price {
            font-size: 14px;
            color: #ffbf0f;
            font-weight: bold;
            margin-top: auto;
        }

        .best-product .product-card .sale {
            background-color: #ffbf0f;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-md-4 {
            flex: 1 1 33%;
            padding: 10px;
        }

        /* Modal overlay styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }

        .modal-box {
            background-color: #ffffff;
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            animation: modalFadeIn 0.4s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

    <div class="hero-wrap" style="background-image: url('{{ asset('foto/bg.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class=""></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-12 ftco-animate d-flex align-items-end">
                    <div class="text w-100">
                        <h1 class="mb-4">Selamat Datang di <br><span>Oldshine Konveksi</span>.</h1>
                        <p class="mb-4">Melayani pembuatan berbagai jenis pakaian seperti kaos, kemeja, hoodie, seragam
                            kantor, dan lainnya. Kualitas terbaik dengan harga bersaing.</p>
                        <p><a href="{{ url('home/produkdaftar') }}" class="btn py-2 px-4"
                                style="background-color: #ffbf0f; color: black">Pesan Sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Kami Section (Dinamis) -->
    <section class="ftco-section ftco-no-pb mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 img img-3 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('foto/' . ($settings['tentang_kami_foto'] ?? 'logo.jpg')) }}" width="100%"
                        style="border-radius: 10px; max-height: 400px; object-fit: cover;">
                </div>
                <div class="col-md-6 wrap-about pl-md-5 ftco-animate py-5">
                    <div class="heading-section">
                        <h2 class="mt-4" style="color: black;">
                            {{ $settings['tentang_kami_judul'] ?? 'Tentang Oldshine Konveksi' }}</h2>
                        <p style="color: black;">
                            {!! nl2br(
                                e(
                                    $settings['tentang_kami_isi'] ??
                                        'Oldshine Konveksi adalah brand terpercaya yang bergerak di bidang konveksi dan produksi pakaian custom.',
                                ),
                            ) !!}
                        </p>
                        <p><a href="{{ url('home/tentang') }}" class="btn py-2 px-4"
                                style="background-color: #ffbf0f; color: black">Tentang Kami</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi Layanan Section (Dinamis) -->
    <section class="ftco-intro">
        <div class="container py-5">
            <div class="text-center mb-4" style="color: black">
                <h1>Informasi Layanan</h1>
                <p>{{ $settings['layanan_subjudul'] ?? 'Kami berkomitmen memberikan layanan terbaik dalam setiap proses produksi pakaian Anda.' }}
                </p>
            </div>
            <div class="row no-gutters">
                <div class="col-md-3 d-flex">
                    <div class="intro d-lg-flex ftco-animate w-100">
                        <div class="text">
                            <h2 style="color: black; font-weight: bold;">
                                {{ $settings['layanan_1_judul'] ?? 'Kualitas Terbaik' }}</h2>
                            <p>{{ $settings['layanan_1_isi'] ?? 'Setiap produk dibuat dengan standar kualitas tinggi dan kontrol yang ketat.' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="intro d-lg-flex ftco-animate w-100">
                        <div class="text">
                            <h2 style="color: black; font-weight: bold;">
                                {{ $settings['layanan_2_judul'] ?? 'Bahan Premium' }}</h2>
                            <p>{{ $settings['layanan_2_isi'] ?? 'Menggunakan material pilihan yang nyaman, awet, dan sesuai kebutuhan Anda.' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="intro d-lg-flex ftco-animate w-100">
                        <div class="text">
                            <h2 style="color: black; font-weight: bold;">
                                {{ $settings['layanan_3_judul'] ?? 'Desain Custom' }}</h2>
                            <p>{{ $settings['layanan_3_isi'] ?? 'Menerima pesanan dengan desain khusus sesuai keinginan pelanggan.' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="intro d-lg-flex ftco-animate w-100">
                        <div class="text">
                            <h2 style="color: black; font-weight: bold;">
                                {{ $settings['layanan_4_judul'] ?? 'Pembayaran Mudah' }}</h2>
                            <p>{{ $settings['layanan_4_isi'] ?? 'Transaksi fleksibel dan dapat dilakukan melalui berbagai metode pembayaran.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Konveksi Terbaik Section -->
    <section class="best-product mt-5">
        <div class="container">
            <div>
                <h1 style="color: black; font-weight:bold;">Produk Konveksi Terbaik</h1>
                <p style="color: black;">Pesan berbagai jenis pakaian custom dengan kualitas unggulan!</p>
            </div>
            <div class="row">
                @foreach ($produk as $product)
                    @php
                        $photos = explode(',', $product->foto);
                        $mainPhoto = $photos[0] ?? 'noimage.png';
                        $hoverPhoto = isset($photos[1]) ? $photos[1] : $mainPhoto;
                    @endphp
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="{{ asset('foto/' . $mainPhoto) }}" alt="{{ $product->nama }}"
                                class="product-img-hover" data-main="{{ asset('foto/' . $mainPhoto) }}"
                                data-hover="{{ asset('foto/' . $hoverPhoto) }}">
                            <h3>{{ $product->nama }}</h3>
                            <p class="price">
                                @if (!empty($product->harga_sebelum) && $product->harga_sebelum > $product->harga)
                                    <span
                                        style="text-decoration: line-through; color: #888; font-size: 0.9em; margin-right: 8px;">Rp
                                        {{ number_format($product->harga_sebelum, 0, ',', '.') }}</span>
                                @endif
                                <span>Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </p>
                            <a href="{{ url('home/detail/' . $product->idproduk) }}" class="btn"
                                style="background-color: #ffbf0f">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Modal Promosi Dinamis -->
    @if (isset($promosiTipe, $promoProducts) && $promosiTipe !== 'mati' && $promoProducts->isNotEmpty())
        <div id="promoModal" class="modal-overlay" style="display: none;">
            <div class="modal-box shadow-lg" style="max-width: 500px; border: 3px solid #ffbf0f;">

                <!-- Header -->
                <div class="modal-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-bullhorn text-warning mr-2"></i>
                        {{ $promoTitle ?? 'Penawaran Khusus' }}
                    </h5>

                    <button type="button" class="close text-white" onclick="closePromoModal()"
                        style="
                        border: none;
                        background: transparent;
                        font-size: 1.5rem;
                        cursor: pointer;
                    ">
                        &times;
                    </button>
                </div>

                <!-- Banner Kampanye Aktif -->
                @if (isset($activePromo) && !empty($activePromo->foto))
                    <div class="text-center p-2 bg-light border-bottom">
                        <img src="{{ asset('foto/' . $activePromo->foto) }}" alt="{{ $activePromo->nama_promosi }}"
                            class="img-fluid rounded shadow-sm"
                            style="
                            max-height: 150px;
                            width: 100%;
                            object-fit: cover;
                        ">
                        @if(!empty($activePromo->deskripsi))
                            <p class="text-muted small mb-0 mt-1 px-2 text-center" style="font-size: 0.85rem; line-height: 1.3;">
                                {{ $activePromo->deskripsi }}
                            </p>
                        @endif
                    </div>
                @endif

                <!-- Body -->
                <div class="modal-body p-1 position-relative">
                    <div id="promoCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                        @if ($promoProducts->count() > 1)
                            <ol class="carousel-indicators" style="bottom: -15px;">
                                @foreach ($promoProducts as $index => $promoProduct)
                                    <li data-target="#promoCarousel" data-slide-to="{{ $index }}"
                                        class="{{ $index === 0 ? 'active' : '' }}"
                                        style="
                                        background-color: #ffbf0f;
                                        width: 8px;
                                        height: 8px;
                                        border-radius: 50%;
                                    ">
                                    </li>
                                @endforeach
                            </ol>
                        @endif

                        <div class="carousel-inner pb-4">
                            @foreach ($promoProducts as $index => $promoProduct)
                                @php
                                    $promoPhotos = explode(',', $promoProduct->foto ?? '');
                                    $promoPhoto = !empty($promoPhotos[0]) ? $promoPhotos[0] : 'noimage.png';
                                @endphp

                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }} px-4 pt-3 pb-2">

                                    <!-- Label tipe promo -->
                                    <div class="text-center">
                                        <span class="badge badge-warning mb-2 py-1 px-2 text-uppercase font-weight-bold"
                                            style="
                                            letter-spacing: 1px;
                                            font-size: 0.75rem;
                                        ">
                                            @switch($promosiTipe)
                                                @case('terbaru')
                                                    Produk Terbaru
                                                @break

                                                @case('terlaris')
                                                    Produk Terlaris
                                                @break

                                                @case('kustom')
                                                    Produk Pilihan
                                                @break

                                                @default
                                                    Penawaran Khusus
                                            @endswitch
                                        </span>

                                        <h3 class="text-black font-weight-bold mb-3">
                                            {{ $promoProduct->nama }}
                                        </h3>
                                    </div>

                                    <!-- Foto produk -->
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('foto/' . $promoPhoto) }}" alt="{{ $promoProduct->nama }}"
                                            class="img-fluid rounded shadow-sm"
                                            style="
                                            max-height: 170px;
                                            width: 100%;
                                            object-fit: cover;
                                        ">
                                    </div>

                                    <!-- Informasi produk -->
                                    <div class="p-3 border rounded bg-white shadow-sm">
                                        <div class="d-flex align-items-center justify-content-between">

                                            <div>
                                                <small class="text-muted d-block">
                                                    Harga Produk
                                                </small>

                                                <div class="font-weight-bold text-danger">
                                                    @if (!empty($promoProduct->harga_sebelum) && $promoProduct->harga_sebelum > $promoProduct->harga)
                                                        <span
                                                            style="
                                                            text-decoration: line-through;
                                                            color: #888;
                                                            font-size: 0.85em;
                                                            margin-right: 5px;
                                                        ">
                                                            Rp
                                                            {{ number_format($promoProduct->harga_sebelum, 0, ',', '.') }}
                                                        </span>
                                                    @endif

                                                    <span>
                                                        Rp
                                                        {{ number_format($promoProduct->harga, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <a href="{{ url('home/detail/' . $promoProduct->idproduk) }}"
                                                class="btn btn-sm btn-warning font-weight-bold text-dark px-3 py-2"
                                                style="
                                                background-color: #ffbf0f;
                                                border: none;
                                                border-radius: 4px;
                                            ">
                                                Lihat Produk
                                                <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Navigasi carousel -->
                        @if ($promoProducts->count() > 1)
                            <a class="carousel-control-prev" href="#promoCarousel" role="button" data-slide="prev"
                                style="width: 8%;">
                                <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"
                                    style="opacity: 0.6;"></span>

                                <span class="sr-only">
                                    Sebelumnya
                                </span>
                            </a>

                            <a class="carousel-control-next" href="#promoCarousel" role="button" data-slide="next"
                                style="width: 8%;">
                                <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"
                                    style="opacity: 0.6;"></span>

                                <span class="sr-only">
                                    Berikutnya
                                </span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-light p-2 d-flex justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-dark px-4 font-weight-bold"
                        onclick="closePromoModal()" style="border-radius: 4px;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <script>
            const promoStorageKey = @json('promo_closed_' . ($promoSignature ?? md5($promosiTipe)));

            document.addEventListener('DOMContentLoaded', function() {
                const promoModal = document.getElementById('promoModal');

                if (
                    promoModal &&
                    !sessionStorage.getItem(promoStorageKey)
                ) {
                    window.setTimeout(function() {
                        promoModal.style.display = 'flex';
                    }, 1200);
                }
            });

            function closePromoModal() {
                const promoModal = document.getElementById('promoModal');

                if (promoModal) {
                    promoModal.style.display = 'none';
                }

                sessionStorage.setItem(promoStorageKey, 'true');
            }

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closePromoModal();
                }
            });

            document.addEventListener('click', function(event) {
                const promoModal = document.getElementById('promoModal');

                if (
                    promoModal &&
                    event.target === promoModal
                ) {
                    closePromoModal();
                }
            });
        </script>
    @endif

@endsection
