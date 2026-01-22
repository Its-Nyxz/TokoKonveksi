@extends('admin.templates.index')

@section('page-content')
    <style>
        .btn-download {
            background-color: #A38758;
            color: white;
        }

        .btn-download:hover {
            color: white;
        }
    </style>
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Data Pembelian</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Daftar</th>
                                <th>Tanggal Pembelian</th>
                                <th>Total Pembelian</th>
                                <th>Metode Pembayaran</th>
                                <th>Status Belanja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            @foreach ($pembelian as $p)
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td>{{ $p->nama }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($dataproduk[$p->idpembelian] as $dp)
                                                <li>
                                                    {{ $dp->nama }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ tanggal(date('Y-m-d', strtotime($p->tanggalbeli))) }}</td>
                                    <td>Rp. {{ number_format($p->totalbeli) }}</td>
                                    <td>{{ $p->metodepembayaran }}</td>
                                    <td>{{ $p->statusbeli }}</td>
                                    <td>
                                        <a href="{{ url('admin/pembayaran/' . $p->idpembelian) }}"
                                            class="btn btn-primary">Detail</a>
                                        <a href="{{ url('admin/invoice/' . $p->idpembelian) }}"
                                            class="btn btn-success">Cetak
                                            Invoice</a>
                                    </td>
                                </tr>
                                <?php $nomor++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- New card for export --}}
            {{-- <div class="card shadow mb-4">
                <div class="card-header py-3 bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Rekapitulasi Laporan</h6>
                </div>
                <div class="card-body text-center">
                    <p>Download Laporan</p>
                    <button class="btn btn-download" id="exportData">
                        Export Data
                    </button>
                </div>
            </div> --}}
        </div>
    </div>

    <script>
        document.getElementById('exportData').addEventListener('click', function() {
            window.location.href = '{{ url('admin/exportpdf') }}';
        });
    </script>
@endsection
