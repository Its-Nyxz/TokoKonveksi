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
                    <h6 class="m-0 font-weight-bold text-white">Data Transaksi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th class="no-sort">No</th>
                                <th>Nama</th>
                                <th class="no-sort">Daftar</th>
                                <th>Tanggal Pembelian</th>
                                <th>Total Pembelian</th>
                                <th>Metode Pengiriman</th>
                                <th class="no-sort">Status Belanja</th>
                                <th class="no-sort">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($pembelian as $p)
                                <tr>
                                    <td class="nomor-urut">{{ $loop->iteration }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($dataproduk[$p->idpembelian] as $dp)
                                                <li>
                                                    {{ $dp->nama }}
                                                    @if ($dp->size_m > 0 || $dp->size_l > 0 || $dp->size_xl > 0 || $dp->size_xxl > 0)
                                                        <br>
                                                        <small class="text-muted">
                                                            Size: 
                                                            @if($dp->size_m > 0) M:{{ $dp->size_m }} @endif
                                                            @if($dp->size_l > 0) L:{{ $dp->size_l }} @endif
                                                            @if($dp->size_xl > 0) XL:{{ $dp->size_xl }} @endif
                                                            @if($dp->size_xxl > 0) XXL:{{ $dp->size_xxl }} @endif
                                                        </small>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ tanggal(date('Y-m-d', strtotime($p->tanggalbeli))) }}</td>
                                    <td>Rp. {{ number_format($p->totalbeli) }}</td>
                                    <td>
                                        @if ($p->metodepembayaran == 'Transfer')
                                            Dengan Kurir
                                        @elseif ($p->metodepembayaran == 'COD')
                                            Tanpa Kurir
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $p->statusbeli }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ url('admin/pembayaran/' . $p->idpembelian) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            <a href="{{ url('admin/invoice/' . $p->idpembelian) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
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
