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
                                <tr>
                                    <td>Catatan Pembeli</td>
                                    <td>{{ $datapembelian->catatan_pembeli }}</td>
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

    <style>
        .proof-container { display: flex; gap: 12px; }
        .proof-item { position: relative; border-radius: 6px; overflow: hidden; }
        .proof-item img { display: block; width: 100%; height: auto; object-fit: cover; }
        .proof-full { width: 100%; }
        .proof-split { display: flex; gap: 12px; }
        .proof-split .proof-item { flex: 1; }
        .img-overlay { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.35); opacity: 0; transition: opacity .15s ease; }
        .proof-item:hover .img-overlay { opacity: 1; }
        .img-overlay i { color: #fff; font-size: 22px; cursor: pointer; }
        /* Modal styles - size to image and avoid stretching */
        .image-modal { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; background: rgba(0,0,0,0.6); z-index: 1050; padding: 20px; }
        .image-modal.open { display: flex; }
        /* modal-content wraps the image and sizes to image dimensions */
        .image-modal .modal-content { position: relative; display: inline-block; max-width: 500px; max-height: 500px; }
        /* Image keeps its natural aspect ratio; constrained to smaller modal size */
        .image-modal img { width: 100%; height: auto; display: block; border-radius: 6px; }
        .modal-close { position: absolute; top: -12px; right: -12px; background: #fff; color: #333; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    </style>

    <div class="row">
        @if (!empty($pembayaran) || $datapembelian->metodepembayaran == 'Cod')
                @if (!in_array($datapembelian->statusbeli, ['Pesanan Di Tolak', 'Selesai']))
                <div class="col-md-6 mb-4 left-column" style="display: flex; flex-direction: column;">
                    <div class="card shadow mb-4 left-card" style="flex: 1; display: flex; flex-direction: column;">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                            <h6 class="m-0 font-weight-bold text-white">Konfirmasi</h6>
                        </div>
                        <div class="card-body" style="flex: 1; overflow-y: auto;">
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
            
            <!-- Right column: stacked Bukti Pembayaran and Foto Pengiriman -->
            <div class="col-md-6 mb-4 right-column" style="display: flex; flex-direction: column; gap: 16px;">
                @if ($datapembelian->metodepembayaran == 'Transfer')
                    <div class="card shadow mb-0" style="flex: 1; display: flex; flex-direction: column;">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                            <h6 class="m-0 font-weight-bold text-white">Bukti Pembayaran</h6>
                        </div>
                        <div class="card-body" style="max-height: 280px; overflow-y: auto; flex: 1;">

                            @php
                                // Find DP and pelunasan entries
                                $dp = $pembayaran->firstWhere('tipe', 'DP');
                                $pelunasan = $pembayaran->firstWhere('tipe', '!=', 'DP');
                            @endphp

                            @if(!$dp && !$pelunasan)
                                <p class="text-danger">Belum ada bukti pembayaran.</p>
                            @else
                                @if($dp && !$pelunasan)
                                    {{-- Only DP: show full-width image inside card --}}
                                    <div class="proof-container">
                                        <div class="proof-item proof-full">
                                            <img src="{{ url('foto/' . $dp->bukti) }}" alt="Bukti DP" />
                                            <div class="img-overlay">
                                                <i class="fa fa-eye" onclick="openImage('{{ url('foto/' . $dp->bukti) }}')"></i>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($dp && $pelunasan)
                                    {{-- Both DP and Pelunasan: show side-by-side --}}
                                    <div class="proof-split">
                                        <div class="proof-item">
                                            <strong>Down Payment (DP)</strong>
                                            <img src="{{ url('foto/' . $dp->bukti) }}" alt="Bukti DP" />
                                            <div class="img-overlay">
                                                <i class="fa fa-eye" onclick="openImage('{{ url('foto/' . $dp->bukti) }}')"></i>
                                            </div>
                                        </div>

                                        <div class="proof-item">
                                            <strong>Pelunasan</strong>
                                            <img src="{{ url('foto/' . $pelunasan->bukti) }}" alt="Bukti Pelunasan" />
                                            <div class="img-overlay">
                                                <i class="fa fa-eye" onclick="openImage('{{ url('foto/' . $pelunasan->bukti) }}')"></i>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Fallback: list any available proofs --}}
                                    @foreach($pembayaran as $p)
                                        <div class="mb-3">
                                            <div class="proof-item">
                                                <strong>{{ $p->tipe == 'DP' ? 'Down Payment (DP)' : 'Pelunasan' }}</strong>
                                                <img src="{{ url('foto/' . $p->bukti) }}" alt="Bukti" />
                                                <div class="img-overlay">
                                                    <i class="fa fa-eye" onclick="openImage('{{ url('foto/' . $p->bukti) }}')"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif

                        </div>
                    </div>
                @endif

                <div class="card shadow mb-0" style="flex: 1; display: flex; flex-direction: column;">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                        <h6 class="m-0 font-weight-bold text-white">Foto Pengiriman</h6>
                    </div>
                    <div class="card-body" style="max-height: 280px; overflow-y: auto; flex: 1;">
                        @if($pembelianFoto->count() == 0)
                            <p class="text-danger">Belum ada foto pengiriman.</p>
                        @elseif($pembelianFoto->count() == 1)
                            {{-- Only one foto: show full-width image --}}
                            @php $foto = $pembelianFoto->first(); @endphp
                            <div class="proof-container">
                                <div class="proof-item proof-full">
                                    <strong>Status: {{ $foto->status }}</strong>
                                    <img src="{{ url('foto/' . $foto->foto) }}" alt="Foto Pengiriman" />
                                    <div class="img-overlay">
                                        <i class="fa fa-eye" onclick="openImage('{{ url('foto/' . $foto->foto) }}')"></i>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Multiple fotos: show side-by-side --}}
                            <div class="proof-split">
                                @foreach($pembelianFoto as $foto)
                                    <div class="proof-item">
                                        <strong>Status: {{ $foto->status }}</strong>
                                        <img src="{{ url('foto/' . $foto->foto) }}" alt="Foto Pengiriman" />
                                        <div class="img-overlay">
                                            <i class="fa fa-eye" onclick="openImage('{{ url('foto/' . $foto->foto) }}')"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
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

    {{-- Modal for viewing images --}}
    <div id="imageModal" class="image-modal" onclick="closeImage(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-close" onclick="closeImage(event)"><i class="fa fa-times"></i></div>
            <img id="modalImage" src="" alt="Preview">
        </div>
    </div>

    <script>
        function openImage(src) {
            var modal = document.getElementById('imageModal');
            var modalImg = document.getElementById('modalImage');
            modalImg.src = src;
            modal.classList.add('open');
        }

        function closeImage(e) {
            var modal = document.getElementById('imageModal');
            modal.classList.remove('open');
            document.getElementById('modalImage').src = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImage(e);
            }
        });

    // Sync the Konfirmasi card height to match the combined stacked right column
    (function() {
        function syncKonfirmasiHeight() {
            var leftCard = document.querySelector('.left-column .left-card');
            var rightCol = document.querySelector('.right-column');
            if (!leftCard || !rightCol) return;
            // reset and measure
            leftCard.style.height = 'auto';
            var target = rightCol.clientHeight;
            if (target && target > 0) leftCard.style.height = target + 'px';
        }

        window.addEventListener('load', function() {
            syncKonfirmasiHeight();
            setTimeout(syncKonfirmasiHeight, 300);
        });
        window.addEventListener('resize', syncKonfirmasiHeight);

        document.querySelectorAll('.right-column img').forEach(function(img) {
            if (!img.complete) img.addEventListener('load', syncKonfirmasiHeight);
        });

        var rightCol = document.querySelector('.right-column');
        if (rightCol && window.MutationObserver) {
            var mo = new MutationObserver(function() { syncKonfirmasiHeight(); });
            mo.observe(rightCol, { childList: true, subtree: true, attributes: true });
        }
    })();
    </script>
@endsection