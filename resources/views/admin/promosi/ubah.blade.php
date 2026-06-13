@extends('admin.templates.index')

@section('page-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Ubah Promosi</h6>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="{{ url('admin/updatepromosi/' . $promosi->id_promosi) }}">
                        @csrf
                        <div class="form-group">
                            <label class="text-dark font-weight-bold">Nama Promosi</label>
                            <input type="text" class="form-control" name="nama_promosi" value="{{ $promosi->nama_promosi }}" required>
                        </div>

                        <div class="form-group">
                            <label class="text-dark font-weight-bold">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="4">{{ $promosi->deskripsi }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="text-dark font-weight-bold">Banner / Foto Promosi Sekarang</label>
                            @if (!empty($promosi->foto))
                                <div class="mb-2">
                                    <img src="{{ asset('foto/' . $promosi->foto) }}" height="120px" class="img-thumbnail" alt="Banner Promosi">
                                </div>
                            @else
                                <div class="mb-2">
                                    <span class="badge badge-secondary">Tidak Ada Banner</span>
                                </div>
                            @endif
                            <input type="file" class="form-control-file" name="foto" accept="image/*">
                            <small class="text-muted">Pilih file baru jika ingin mengganti banner/foto promosi ini.</small>
                        </div>

                        <div class="form-group">
                            <label class="text-dark font-weight-bold">Pilih Produk untuk Promosi</label>
                            <input type="text" id="search-product" class="form-control mb-2" placeholder="Cari nama produk di sini...">
                            <div class="border rounded p-3 bg-light" style="max-height: 250px; overflow-y: auto;">
                                @if($produk->isEmpty())
                                    <span class="text-muted">Belum ada produk terdaftar.</span>
                                @else
                                    @foreach ($produk as $p)
                                        @php
                                            $isChecked = in_array($p->idproduk, $selected_produk) ? 'checked' : '';
                                        @endphp
                                        <div class="custom-control custom-checkbox mb-2 product-item">
                                            <input type="checkbox" name="produk_ids[]" value="{{ $p->idproduk }}" id="prod_{{ $p->idproduk }}" class="custom-control-input" {{ $isChecked }}>
                                            <label for="prod_{{ $p->idproduk }}" class="custom-control-label product-name" style="cursor: pointer;">
                                                {{ $p->nama }} - <span class="text-success font-weight-bold">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <small class="text-muted">Centang produk yang ingin dimasukkan ke dalam promosi ini. Ketik di kolom pencarian untuk menyaring produk.</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="is_active" id="is_active" value="1" {{ $promosi->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label text-dark font-weight-bold" for="is_active" style="cursor: pointer;">Aktifkan Promosi</label>
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-secondary font-weight-bold text-dark"><i class="fas fa-save mr-2"></i>Simpan Perubahan</button>
                        <a href="{{ url('admin/promosi') }}" class="btn btn-dark font-weight-bold text-white"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-product');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    let query = this.value.toLowerCase();
                    document.querySelectorAll('.product-item').forEach(function(item) {
                        let name = item.querySelector('.product-name').textContent.toLowerCase();
                        if (name.includes(query)) {
                            item.style.setProperty('display', 'block', 'important');
                        } else {
                            item.style.setProperty('display', 'none', 'important');
                        }
                    });
                });
            }
        });
    </script>
@endsection
