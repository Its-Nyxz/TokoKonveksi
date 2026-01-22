@extends('home.templates.index')

@section('page-content')
    <style>
        <style>.product {
            position: relative;
        }

        .sale-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ffbf0f;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            z-index: 10;
            /* Pastikan label muncul di atas gambar */
        }
    </style>

    </style>

    <section class="ftco-section">
        <div class="container">
            {{-- <div class="row mb-5">
                <div class="col-md-12">
                    <form method="GET" action="{{ url('home/produkfilter') }}" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Cari produk..."
                            value="{{ request('search') }}">
                        <select name="sort_by" class="form-control mr-2">
                            <option value="">Sortir berdasarkan</option>
                            <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Harga
                                Terendah</option>
                            <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Harga
                                Tertinggi</option>
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Nama A-Z
                            </option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Nama Z-A
                            </option>
                        </select>
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="{{ url('home/produkdaftar') }}" class="btn btn-primary ml-2">Lihat Semua</a>
                    </form>
                </div>
            </div> --}}
            <div class="mb-5">
                <h1 style="color: black; font-weight:bold;">Produk</h1>
                <p style="color: black;">Pesan Sekarang Untuk Mendapatkanya.</p>
            </div>
            <div class="row">
                @foreach ($produk as $p)
                    <div class="col-md-4 d-flex">
                        <div class="product ftco-animate">
                            <span class="sale-label">Sale</span>
                            <div class="img d-flex align-items-center justify-content-center"
                                style="background-image: url('{{ asset('foto/' . $p->foto) }}');">
                                <div class="desc">
                                    <p class="meta-prod d-flex">
                                        <a href="{{ url('home/detail/' . $p->idproduk) }}"
                                            class="d-flex align-items-center justify-content-center">
                                            <span class="flaticon-visibility"></span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="text text-center">
                                <!-- <span class="category">{{ $p->namakategori }}</span> -->
                                <!-- <span class="price">Stok : {{ $p->stok }}</span> -->
                                <p class="text-right" style="color: #ffbf0f; font-weight:bold;">Rp
                                    {{ number_format($p->harga) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                {{ $produk->links() }}
            </div>
        </div>
    </section>
@endsection
