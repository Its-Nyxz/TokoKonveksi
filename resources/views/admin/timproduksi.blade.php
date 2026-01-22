@extends('admin.templates.index')

@section('page-content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ url('admin/tambahtimproduksi') }}" class="btn btn-sm btn-secondary shadow-sm float-right pull-right">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Tim Produksi</a>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Data Tim Produksi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat, Tgl Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($timproduksi as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->telepon }}</td>
                                    <td>{{ $data->jekel }}</td>
                                    <td>{{ $data->tempat_lahir }}, {{ date('d M Y', strtotime($data->tgl_lahir)) }}</td>
                                    <td>
                                        <a href="{{ url('admin/ubahtimproduksi/' . $data->id) }}"
                                            class="btn btn-primary btn-sm">Ubah</a>
                                        <a href="{{ url('admin/hapustimproduksi/' . $data->id) }}"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
