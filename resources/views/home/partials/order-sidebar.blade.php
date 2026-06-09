@php
    $slideItemsOrder = [];

    foreach ($dataproduk as $_sp) {
        $fotoList = !empty($_sp->foto) ? array_filter(explode(',', $_sp->foto)) : [];

        if (empty($fotoList)) {
            $slideItemsOrder[] = [
                'nama' => $_sp->nama,
                'foto' => asset('foto/noimage.png'),
            ];
        } else {
            foreach ($fotoList as $_f) {
                $slideItemsOrder[] = [
                    'nama' => $_sp->nama,
                    'foto' => asset('foto/' . trim($_f)),
                ];
            }
        }
    }

    $alamatLengkap = collect([
        $datapembelian->alamat ?? null,
        $datapembelian->kec ?? null,
        $datapembelian->kota ?? null,
        $datapembelian->provinsi ?? null,
        $datapembelian->kode_pos ?? null,
    ])
        ->filter()
        ->implode(', ');

    $statusClass = in_array($datapembelian->statusbeli, ['Selesai'])
        ? 'success'
        : (in_array($datapembelian->statusbeli, ['Pesanan Di Tolak'])
            ? 'danger'
            : 'warning');
@endphp

<style>
    .order-side-card {
        overflow: hidden;
    }

    .order-no-card {
        padding: 12px 14px;
    }

    .order-no-card p {
        margin-bottom: 0;
        color: #777;
    }

    .order-no-card span {
        color: #000;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .order-product-card {
        padding: 12px 14px 0;
    }

    .order-product-title {
        color: #000;
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .order-origin {
        display: block;
        margin-bottom: 10px;
        color: #8a8a8a;
        font-size: 0.8rem;
    }

    .order-slide-wrapper {
        position: relative;
        width: 100%;
        height: 240px;
        border-radius: 8px;
        overflow: hidden;
        background: #f0f0f0;
    }

    .product-slide {
        position: absolute;
        inset: 0;
        transition: opacity 0.6s ease;
    }

    .product-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .slide-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin: 0 3px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .slide-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.35);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        font-size: 14px;
        cursor: pointer;
        z-index: 11;
    }

    .slide-arrow-left {
        left: 4px;
    }

    .slide-arrow-right {
        right: 4px;
    }

    .customer-detail-box {
        margin-top: 16px;
        font-size: 0.85rem;
    }

    .customer-address {
        padding: 0 10px 12px;
    }

    .customer-address strong {
        display: block;
        color: #333;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .customer-address span {
        color: #555;
        line-height: 1.5;
    }

    .customer-detail-row {
        display: grid;
        grid-template-columns: 110px 10px 1fr;
        gap: 8px;
        padding: 8px 10px;
        border-top: 1px solid #f1f1f1;
        align-items: flex-start;
    }

    .customer-detail-label {
        color: #333;
        font-weight: 600;
    }

    .customer-detail-separator {
        color: #555;
    }

    .customer-detail-value {
        color: #555;
        word-break: break-word;
    }
</style>

<div class="card order-no-card">
    <p>
        <strong>No Transaksi:</strong><br>
        <span>{{ $datapembelian->notransaksi ?? '-' }}</span>
    </p>
</div>

<div class="card mt-3 order-product-card order-side-card">
    <h3 class="order-product-title" id="previewProductTitle">
        {{ $slideItemsOrder[0]['nama'] ?? 'Produk' }}
    </h3>

    <span class="order-origin">Kota Asal: Kabupaten Wonogiri</span>

    <div id="productSlideWrapper" class="order-slide-wrapper">
        @foreach ($slideItemsOrder as $si => $slide)
            <div class="product-slide" data-index="{{ $si }}" data-nama="{{ $slide['nama'] }}"
                style="opacity: {{ $si == 0 ? 1 : 0 }};">
                <img src="{{ $slide['foto'] }}" alt="{{ $slide['nama'] }}">
            </div>
        @endforeach

        @if (count($slideItemsOrder) > 1)
            <div id="slideDots" style="position:absolute; bottom:8px; left:0; right:0; text-align:center; z-index:10;">
                @foreach ($slideItemsOrder as $di => $_)
                    <span class="slide-dot" data-dot="{{ $di }}"
                        style="background: {{ $di == 0 ? '#ffbf0f' : 'rgba(255,255,255,0.6)' }};">
                    </span>
                @endforeach
            </div>

            <button type="button" onclick="slideMove(-1)" class="slide-arrow slide-arrow-left">&lsaquo;</button>
            <button type="button" onclick="slideMove(1)" class="slide-arrow slide-arrow-right">&rsaquo;</button>
        @endif
    </div>

    <div class="customer-detail-box">
        <div class="customer-address">
            <strong>Alamat Pengiriman:</strong>
            <span>{{ $alamatLengkap ?: '-' }}</span>
        </div>

        <div class="customer-detail-row">
            <div class="customer-detail-label">Penerima</div>
            <div class="customer-detail-separator">:</div>
            <div class="customer-detail-value">{{ $datapembelian->nama ?? '-' }}</div>
        </div>

        <div class="customer-detail-row">
            <div class="customer-detail-label">Tgl Pesan</div>
            <div class="customer-detail-separator">:</div>
            <div class="customer-detail-value">
                {{ !empty($datapembelian->tanggalbeli) ? tanggal(date('Y-m-d', strtotime($datapembelian->tanggalbeli))) : '-' }}
            </div>
        </div>

        <div class="customer-detail-row">
            <div class="customer-detail-label">No. Telepon</div>
            <div class="customer-detail-separator">:</div>
            <div class="customer-detail-value">{{ $datapembelian->telepon ?? '-' }}</div>
        </div>

        <div class="customer-detail-row">
            <div class="customer-detail-label">Status</div>
            <div class="customer-detail-separator">:</div>
            <div class="customer-detail-value">
                <span class="badge badge-{{ $statusClass }}">
                    {{ $datapembelian->statusbeli ?? '-' }}
                </span>
            </div>
        </div>
    </div>
</div>
