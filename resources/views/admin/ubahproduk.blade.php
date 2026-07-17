@extends('admin.templates.index')

@section('page-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Ubah Produk</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" enctype="multipart/form-data"
                        action="{{ url('admin/updateproduk/' . $produk->idproduk) }}">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" value="{{ $produk->nama }}">
                        </div>
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <select class="form-control" name="idkategori">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->idkategori }}" @if ($k->idkategori == $produk->idkategori) selected @endif>
                                        {{ $k->namakategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="stok" value="999999">
                        <div class="form-group">
                            <label>Harga (Rp)</label>
                            <input type="number" class="form-control" name="harga" value="{{ $produk->harga }}" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Sebelum Diskon (Harga Coret, Opsional) (Rp)</label>
                            <input type="number" class="form-control" name="harga_sebelum" value="{{ $produk->harga_sebelum }}" min="0">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="10" required>{{ $produk->deskripsi }}</textarea>
                            <script>
                                CKEDITOR.replace('deskripsi');
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Foto (Bisa lebih dari 1, upload baru akan menimpa foto lama)</label>
                            <div class="letak-input" style="margin-bottom: 10px;">
                                <input type="file" class="form-control" name="foto[]" multiple>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary" name="save"><i
                                class="glyphicon glyphicon-saved"></i>Simpan</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
