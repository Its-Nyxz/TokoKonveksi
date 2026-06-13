@extends('admin.templates.index')

@section('page-content')
    <style>
        table.dataTable thead th.no-sort::before,
        table.dataTable thead th.no-sort::after {
            display: none !important;
            content: "" !important;
        }

        table.dataTable thead th.no-sort {
            pointer-events: none;
            cursor: default !important;
            background-image: none !important;
        }
    </style>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ url('admin/tambahpromosi') }}" class="btn btn-sm btn-secondary shadow-sm float-right pull-right"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Promosi</a>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Data Promosi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th class="no-sort" style="width: 50px;">No</th>
                                <th>Banner / Foto</th>
                                <th>Nama Promosi</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Produk Terkait</th>
                                <th class="no-sort" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($promosi as $data)
                                <tr>
                                    <td class="nomor-urut">{{ $loop->iteration }}</td>
                                    <td>
                                        @if (!empty($data->foto))
                                            <img src="{{ asset('foto/' . $data->foto) }}" alt="{{ $data->nama_promosi }}" width="120px" class="img-thumbnail">
                                        @else
                                            <span class="badge badge-secondary">Tidak Ada Banner</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $data->nama_promosi }}</strong></td>
                                    <td>{{ $data->deskripsi ?? '-' }}</td>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->produk->isEmpty())
                                            <span class="text-muted">Semua Produk</span>
                                        @else
                                            <ul class="pl-3 mb-0">
                                                @foreach ($data->produk as $prod)
                                                    <li>{{ $prod->nama }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{ url('admin/ubahpromosi/' . $data->id_promosi) }}"
                                                class="btn btn-primary btn-sm mr-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{ url('admin/hapuspromosi/' . $data->id_promosi) }}"
                                                class="btn btn-danger btn-sm btn-delete"><i
                                                    class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                $(document).on('click', '.btn-delete', function(e) {
                    e.preventDefault();

                    var getLink = $(this).attr('href');

                    Swal.fire({
                        title: "Apakah Anda Yakin?",
                        text: "Data promosi ini beserta relasi produknya akan dihapus secara permanen!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = getLink;
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                if ($.fn.dataTable.isDataTable('#table')) {
                    const table = $('#table').DataTable();

                    table.on('order.dt search.dt draw.dt', function() {
                        let nomor = 1;

                        table.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell) {
                            cell.innerHTML = nomor++;
                        });
                    }).draw();
                }
            });
        </script>
    </div>
@endsection
