@extends('home.templates.index')

@section('page-content')
    <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ url('foto/bg.jpg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate mb-5 text-center">
                    <p class="breadcrumbs mb-0"><span class="mr-2"><a href="{{ url('/') }}">Home <i
                                    class="fa fa-chevron-right"></i></a></span>
                        <span>Kategori <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h2 class="mb-0 bread">Kategori</h2>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            {{-- <div class="row mb-5">
                <div class="col-md-12">
                    <form method="GET" action="{{ url('home/kategorifilter/') }}" class="form-inline">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Cari kategori..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn" style="background-color: #ffbf0f">Cari</button>
                        <a href="{{ url('home/kategori/') }}" class="btn ml-2" style="background-color: #ffbf0f">Lihat
                            Semua</a>
                    </form>
                </div>
            </div> --}}
            <div class="row">
                @foreach ($kategori as $category)
                    <div class="col-md-6 col-lg-3 ftco-animate text-center mb-3">
                        <a href="{{ url('home/kategori/' . $category->idkategori) }}" class="btn btn-lg"
                            style="background-color: #ffbf0f; color: white; width: 100%; font-weight: bold;">
                            {{ $category->namakategori }}
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                {{ $kategori->links() }}
            </div>
        </div>
    </section>
@endsection
