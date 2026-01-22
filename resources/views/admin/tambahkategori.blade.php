@extends('admin.templates.index')

@section('page-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Tambah Kategori</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('admin/simpankategori') }}">
                        @csrf

                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" name="kategori" placeholder="Masukkan nama kategori">
                        </div>

                        <button class="btn btn-secondary" name="tambah">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
