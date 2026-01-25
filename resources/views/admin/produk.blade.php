@extends('admin.templates.index')

@section('page-content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ url('admin/tambahproduk') }}" class="btn btn-sm btn-secondary shadow-sm float-right pull-right"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk</a>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Data Produk</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            @foreach ($produk as $p)
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->namakategori }}</td>
                                    <td>{{ $p->stok }}</td>
                                    <td>{{ rupiah($p->harga) }}</td>
                                    <td>
                                        <img src="{{ asset('foto/' . $p->foto) }}" width="100px">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ url('admin/ubahproduk/' . $p->idproduk) }}" class="btn btn-primary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <a href="{{ url('admin/hapusproduk/' . $p->idproduk) }}"
                                                class="btn btn-danger btn-delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $nomor++; ?>
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
                        text: "Data produk ini akan dihapus secara permanen!",
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
