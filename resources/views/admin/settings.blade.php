@extends('admin.templates.index')

@section('page-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Pengaturan Dinamis & Promosi</h6>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="post" enctype="multipart/form-data" action="{{ url('admin/savesettings') }}">
                        @csrf

                        <!-- Card Section: Tentang Kami -->
                        <div class="card mb-4 border-left-warning shadow-sm">
                            <div class="card-body">
                                <h5 class="text-black font-weight-bold mb-3"><i class="fas fa-info-circle mr-2"></i>Bagian "Tentang Kami"</h5>
                                <div class="form-group">
                                    <label class="text-black font-weight-bold">Judul</label>
                                    <input type="text" class="form-control" name="tentang_kami_judul" value="{{ $settings['tentang_kami_judul'] ?? '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="text-black font-weight-bold">Isi Deskripsi Tentang Kami</label>
                                    <textarea class="form-control" name="tentang_kami_isi" rows="4" required>{{ $settings['tentang_kami_isi'] ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="text-black font-weight-bold">Foto Cover Tentang Kami</label>
                                    @if (!empty($settings['tentang_kami_foto']))
                                        <div class="mb-2">
                                            <img src="{{ asset('foto/' . $settings['tentang_kami_foto']) }}" height="120px" class="img-thumbnail" alt="Cover Tentang Kami">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" name="tentang_kami_foto" accept="image/*">
                                    <small class="text-muted">Pilih file jika ingin memperbarui foto cover.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Card Section: Informasi Layanan -->
                        <div class="card mb-4 border-left-info shadow-sm">
                            <div class="card-body">
                                <h5 class="text-black font-weight-bold mb-3"><i class="fas fa-concierge-bell mr-2"></i>Bagian "Informasi Layanan"</h5>
                                <div class="form-group">
                                    <label class="text-black font-weight-bold">Subjudul Informasi Layanan</label>
                                    <input type="text" class="form-control" name="layanan_subjudul" value="{{ $settings['layanan_subjudul'] ?? '' }}" required>
                                </div>

                                <hr class="my-4">

                                <div class="row">
                                    <!-- Layanan 1 -->
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-dark font-weight-bold"><i class="fas fa-star text-warning mr-1"></i>Layanan 1</h6>
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" class="form-control" name="layanan_1_judul" value="{{ $settings['layanan_1_judul'] ?? '' }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi Singkat</label>
                                                <textarea class="form-control" name="layanan_1_isi" rows="2" required>{{ $settings['layanan_1_isi'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Layanan 2 -->
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-dark font-weight-bold"><i class="fas fa-star text-warning mr-1"></i>Layanan 2</h6>
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" class="form-control" name="layanan_2_judul" value="{{ $settings['layanan_2_judul'] ?? '' }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi Singkat</label>
                                                <textarea class="form-control" name="layanan_2_isi" rows="2" required>{{ $settings['layanan_2_isi'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Layanan 3 -->
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-dark font-weight-bold"><i class="fas fa-star text-warning mr-1"></i>Layanan 3</h6>
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" class="form-control" name="layanan_3_judul" value="{{ $settings['layanan_3_judul'] ?? '' }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi Singkat</label>
                                                <textarea class="form-control" name="layanan_3_isi" rows="2" required>{{ $settings['layanan_3_isi'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Layanan 4 -->
                                    <div class="col-md-6 mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-dark font-weight-bold"><i class="fas fa-star text-warning mr-1"></i>Layanan 4</h6>
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" class="form-control" name="layanan_4_judul" value="{{ $settings['layanan_4_judul'] ?? '' }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi Singkat</label>
                                                <textarea class="form-control" name="layanan_4_isi" rows="2" required>{{ $settings['layanan_4_isi'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Section: Pengaturan Promosi (Modal) -->
                        <div class="card mb-4 border-left-success shadow-sm">
                            <div class="card-body">
                                <h5 class="text-black font-weight-bold mb-3"><i class="fas fa-bullhorn mr-2"></i>Pengaturan Promosi (Popup Home)</h5>
                                <div class="form-group">
                                    <label class="text-black font-weight-bold">Tipe Promosi</label>
                                    <select class="form-control" name="promosi_tipe" id="promosi_tipe" required>
                                        <option value="mati" {{ ($settings['promosi_tipe'] ?? '') == 'mati' ? 'selected' : '' }}>Nonaktifkan Promosi (Mati)</option>
                                        <option value="terbaru" {{ ($settings['promosi_tipe'] ?? '') == 'terbaru' ? 'selected' : '' }}>Tampilkan Produk Terbaru otomatis</option>
                                        <option value="terlaris" {{ ($settings['promosi_tipe'] ?? '') == 'terlaris' ? 'selected' : '' }}>Tampilkan Produk Terlaris otomatis</option>
                                        <option value="kustom" {{ ($settings['promosi_tipe'] ?? '') == 'kustom' ? 'selected' : '' }}>Tampilkan Produk Kustom (Pilih Produk di bawah)</option>
                                    </select>
                                </div>

                                <div class="form-group" id="kustom_produk_div" style="display: none;">
                                    <label class="text-black font-weight-bold">Pilih Produk untuk Promosi</label>
                                    <select class="form-control" name="promosi_produk_id" id="promosi_produk_id">
                                        <option value="">Pilih Produk</option>
                                        @foreach ($produk as $p)
                                            <option value="{{ $p->idproduk }}" {{ ($settings['promosi_produk_id'] ?? '') == $p->idproduk ? 'selected' : '' }}>
                                                {{ $p->nama }} - Rp {{ number_format($p->harga) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-secondary btn-lg btn-block font-weight-bold text-white"><i class="fas fa-save mr-2"></i>Simpan Seluruh Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const promosiTipe = document.getElementById('promosi_tipe');
            const kustomDiv = document.getElementById('kustom_produk_div');

            function toggleKustomDiv() {
                if (promosiTipe.value === 'kustom') {
                    kustomDiv.style.display = 'block';
                    document.getElementById('promosi_produk_id').setAttribute('required', 'required');
                } else {
                    kustomDiv.style.display = 'none';
                    document.getElementById('promosi_produk_id').removeAttribute('required');
                }
            }

            promosiTipe.addEventListener('change', toggleKustomDiv);
            toggleKustomDiv(); // Run on init
        });
    </script>
@endsection
