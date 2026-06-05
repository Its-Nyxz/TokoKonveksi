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
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Data Member</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th class="no-sort">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th class="no-sort">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($pengguna as $pecah)
                                <tr>
                                    <td class="nomor-urut">{{ $loop->iteration }}</td>
                                    <td>{{ $pecah->nama }}</td>
                                    <td>{{ $pecah->email }}</td>
                                    <td>{{ $pecah->telepon }}</td>
                                    <td>{{ $pecah->alamat }}</td>
                                    <td>
                                        <a href="{{ url('admin/hapuspengguna/' . $pecah->id) }}"
                                            class="btn btn-danger btn-delete">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                // Gunakan $(document).on agar tombol di halaman pagination tetap berfungsi
                $(document).on('click', '.btn-delete', function(e) {
                    e.preventDefault();

                    var getLink = $(this).attr('href');

                    Swal.fire({
                        title: "Apakah Anda Yakin?",
                        text: "Data pengguna ini akan dihapus secara permanen!",
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
    </div>
@endsection
