@extends('home.templates.index')

@section('page-content')

    <head>
        <!-- Include Font Awesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <style>
        .ftco-intro {
            background-color: #ffbf0f;
            /* Updated to new color */
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
            /* Updated to new color */
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
            /* Updated to new color */
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

        .latest-articles {
            padding: 50px 0;
        }

        .latest-articles .article-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            max-height: 600px;
        }

        .latest-articles .article-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .latest-articles .article-card .content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .latest-articles .article-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .latest-articles .article-card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .latest-articles .article-card .read-more {
            font-size: 14px;
            color: #A38758;
            font-weight: bold;
            text-decoration: none;
        }

        .latest-articles .article-card .date {
            font-size: 12px;
            color: #999;
            margin-top: 10px;
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

    <section class="ftco-section ftco-no-pb mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 img img-3 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('foto/logo.jpg') }}" width="100%" style="border-radius: 10px">
                </div>
                <div class="col-md-6 wrap-about pl-md-5 ftco-animate py-5">
                    <div class="heading-section">
                        <h2 class="mt-4" style="color: black;">Tentang Oldshine Konveksi</h2>
                        <p style="color: black;">
                            Oldshine Konveksi adalah layanan konveksi terpercaya yang menyediakan berbagai produk pakaian
                            custom seperti kaos sablon, seragam, jaket, dan kebutuhan apparel lainnya. Kami mengutamakan
                            bahan berkualitas, pengerjaan rapi, serta pelayanan profesional.
                        </p>
                        <p><a href="{{ url('home/tentang') }}" class="btn py-2 px-4"
                                style="background-color: #ffbf0f; color: black">Tentang Kami</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-intro">
        <div class="container py-5">
            <div class="text-center" style="color: black">
                <h1>Informasi Layanan</h1>
                <p>Kami berkomitmen memberikan layanan terbaik dalam setiap proses produksi pakaian Anda.</p>
            </div>
            <div class="row no-gutters">
                <div class="col-md-3 d-flex">
                    <div class="intro d-lg-flex ftco-animate">
                        <div class="text">
                            <h2 style="color: black;">Kualitas Terbaik</h2>
                            <p>Setiap produk dibuat dengan standar kualitas tinggi dan kontrol yang ketat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="intro d-lg-flex ftco-animate">
                        <div class="text">
                            <h2 style="color: black;">Bahan Premium</h2>
                            <p>Menggunakan material pilihan yang nyaman, awet, dan sesuai kebutuhan Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="intro d-lg-flex ftco-animate">
                        <div class="text">
                            <h2 style="color: black;">Desain Custom</h2>
                            <p>Menerima pesanan dengan desain khusus sesuai keinginan pelanggan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="intro d-lg-flex ftco-animate">
                        <div class="text">
                            <h2 style="color: black;">Pembayaran Mudah</h2>
                            <p>Transaksi fleksibel dan dapat dilakukan melalui berbagai metode pembayaran.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="best-product mt-5">
        <div class="container">
            <div>
                <h1 style="color: black; font-weight:bold;">Produk Konveksi Terbaik</h1>
                <p style="color: black;">Pesan berbagai jenis pakaian custom dengan kualitas unggulan!</p>
            </div>
            <div class="row">
                @foreach ($produk as $product)
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="{{ asset('foto/' . $product->foto) }}" alt="{{ $product->nama }}">
                            <h3>{{ $product->nama }}</h3>
                            <p class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            <a href="{{ url('home/detail/' . $product->idproduk) }}" class="btn"
                                style="background-color: #ffbf0f">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    {{-- <section class="latest-articles">
        <div class="container">
            <h2 style="color: black;">Artikel Terbaru</h2>
            <div class="row">
                @foreach ($articles as $article)
                    <div class="col-md-4">
                        <div class="article-card">
                            <img src="{{ asset('images/' . $article->image) }}" alt="{{ $article->title }}">
                            <div class="content">
                                <h3>{{ $article->title }}</h3>
                                <p>{{ Str::limit($article->content, 100) }}</p>
                                <p class="date">{{ $article->created_at->format('d M Y') }}</p>
                                <a href="{{ url('home/artikel/' . $article->id) }}" class="read-more">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}
@endsection
