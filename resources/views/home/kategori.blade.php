@extends('home.templates.index')

@section('page-content')
    <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ url('foto/bg.jpg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate mb-5 text-center">
                    <p class="breadcrumbs mb-0">
                        <span class="mr-2">
                            <a href="{{ url('/') }}">
                                Home <i class="fa fa-chevron-right"></i>
                            </a>
                        </span>
                        <span>Kategori <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h2 class="mb-0 bread">Kategori</h2>
                </div>
            </div>
        </div>
    </section>

    <style>
        .kategori-card {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 70px;
            padding: 14px 18px;
            border-radius: 12px;
            background-color: #ffbf0f;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease-in-out;
        }

        .kategori-card:hover {
            background-color: #d99f00;
            color: #ffffff;
            text-decoration: none;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        .kategori-pagination {
            margin-top: 35px;
        }

        .kategori-empty {
            padding: 30px;
            border-radius: 12px;
            background-color: #f8f9fa;
            text-align: center;
            color: #777;
        }
    </style>

    <section class="ftco-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <h3 style="font-weight: bold; color: #000;">Pilih Kategori</h3>
                    <p style="color: #777;">Silakan pilih kategori produk yang tersedia</p>
                </div>
            </div>

            <div class="row">
                @forelse ($kategori as $category)
                    <div class="col-6 col-md-4 col-lg-3 mb-4 ftco-animate">
                        <a href="{{ url('home/kategori/' . $category->idkategori) }}" class="kategori-card">
                            {{ $category->namakategori }}
                        </a>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="kategori-empty">
                            Belum ada kategori tersedia.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="kategori-pagination d-flex justify-content-center">
                {{ $kategori->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
