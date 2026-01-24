@extends('admin.templates.index')

@section('page-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Daftar Pembelian</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td><strong>No. Pembelian</strong></td>
                                    <td>{{ $datapembelian->idpembelian }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>{{ tanggal(date('Y-m-d', strtotime($datapembelian->tanggalbeli))) }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ $datapembelian->statusbeli }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>Rp. {{ number_format($datapembelian->totalbeli) }}</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>{{ $datapembelian->metodepembayaran }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td>{{ $datapembelian->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Telepon</td>
                                    <td>{{ $datapembelian->telepon }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $datapembelian->email }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>{{ $datapembelian->alamat }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Sub Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            $jumlahtotal = 0;
                            ?>
                            @foreach ($dataproduk as $dp)
                                @php
                                    $jumlahtotal += $dp->jumlah;
                                @endphp
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td>{{ $dp->nama }}</td>
                                    <td>Rp. {{ number_format($dp->harga) }}</td>
                                    <td>{{ $dp->jumlah }}</td>
                                    <td>Rp. {{ number_format($dp->harga * $dp->jumlah) }}</td>

                                </tr>
                                <?php $nomor++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if (!empty($pembayaran) || $datapembelian->metodepembayaran == 'Cod')
            @if (!in_array($datapembelian->statusbeli, ['Pesanan Di Tolak', 'Selesai']))
                <div class="col-md-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                            <h6 class="m-0 font-weight-bold text-white">Konfirmasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @if ($pembayaran->count() > 0)
                                        @php $firstPay = $pembayaran->first(); @endphp
                                        <table class="table">
                                            <tr>
                                                <th>Nama</th>
                                                <th>{{ $firstPay->nama }}</th>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Transfer</th>
                                                <th>
                                                    {{ tanggal(date('Y-m-d', strtotime($firstPay->tanggaltransfer))) }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Upload Bukti Pembayaran</th>
                                                <th>
                                                    {{ tanggal(date('Y-m-d', strtotime($firstPay->tanggal))) }}
                                                </th>
                                            </tr>
                                        </table>
                                    @else
                                        <div class="alert alert-warning">
                                            Data rincian pembayaran belum tersedia.
                                        </div>
                                    @endif
                                    <form method="post"
                                        action="{{ url('admin/simpanpembayaran/' . $datapembelian->idpembelian) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ $datapembelian->id }}" name="id">
                                        <input type="hidden" value="{{ $jumlahtotal }}" name="jumlahtotal">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="statusbeli" id="statusbeli" required>
                                                <option value="" selected disabled>Belum di Konfirmasi</option>
                                                <option value="Pesanan Di Tolak"
                                                    {{ $datapembelian->statusbeli == 'Pesanan Di Tolak' ? 'selected' : '' }}>
                                                    Pesanan Di Tolak</option>
                                                <option value="Pesanan Di Terima"
                                                    {{ $datapembelian->statusbeli == 'Pesanan Di Terima' ? 'selected' : '' }}>
                                                    Pesanan Di Terima</option>
                                                <option value="Pesanan Sedang Dikirim"
                                                    {{ $datapembelian->statusbeli == 'Pesanan Sedang Dikirim' ? 'selected' : '' }}>
                                                    Pesanan Sedang Dikirim</option>
                                                <option value="Selesai"
                                                    {{ $datapembelian->statusbeli == 'Selesai' ? 'selected' : '' }}>
                                                    Selesai</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea class="form-control" name="catatan" required>{{ $datapembelian->catatan }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Foto Pengiriman</label>
                                            <input type="file" class="form-control" name="foto">
                                        </div>
                                        <button class="btn btn-secondary float-right pull-right"
                                            name="proses">Simpan</button>
                                        <br>
                                    </form>

                                    <script>
                                        document.getElementById('statusbeli').addEventListener('change', function() {
                                            var kurirDiv = document.getElementById('kurirDiv');
                                            var kurirSelect = kurirDiv.querySelector('select');

                                            if (this.value === 'Pesanan Sedang Dikirim') {
                                                kurirDiv.style.display = 'block'; // Tampilkan select kurir
                                            } else {
                                                kurirDiv.style.display = 'none'; // Sembunyikan select kurir
                                                kurirSelect.value = ''; // Reset value ke default (kosong)
                                            }
                                        });

                                        // Jika halaman di-load ulang dan status sebelumnya adalah "Pesanan Sedang Dikirim", tampilkan select kurir
                                        window.onload = function() {
                                            var statusbeli = document.getElementById('statusbeli').value;
                                            var kurirDiv = document.getElementById('kurirDiv');
                                            var kurirSelect = kurirDiv.querySelector('select');

                                            if (statusbeli === 'Pesanan Sedang Dikirim') {
                                                kurirDiv.style.display = 'block';
                                            } else {
                                                kurirDiv.style.display = 'none';
                                                kurirSelect.value = ''; // Pastikan value tetap kosong saat reload
                                            }
                                        };
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($datapembelian->metodepembayaran == 'Transfer')
                <div class="col-md-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                            <h6 class="m-0 font-weight-bold text-white">Bukti Pembayaran</h6>
                        </div>
                        <div class="card-body">

                            @forelse ($pembayaran as $p)
                                <div class="mb-3">
                                    <strong>{{ $p->tipe == 'DP' ? 'Down Payment (DP)' : 'Pelunasan' }}</strong><br>
                                    <img src="{{ url('foto/' . $p->bukti) }}" alt="" width="100%"
                                        class="img-responsive">
                                    <hr>
                                </div>
                            @empty
                                <p class="text-danger">Belum ada bukti pembayaran.</p>
                            @endforelse

                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                        <h6 class="m-0 font-weight-bold text-white">Foto Pengiriman</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($pembelianFoto as $foto)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                            <p class="font-weight-bold">Status: {{ $foto->status }}</p>
                                            <div class="image-container text-center">
                                                <img src="{{ url('foto/' . $foto->foto) }}" alt="Bukti Pengiriman"
                                                    class="img-fluid img-thumbnail" style="max-width: 300px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                        <h6 class="m-0 font-weight-bold text-white">Status Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <p>Belum melakukan pembayaran</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
