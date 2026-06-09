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

        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
        }

        input[type="date"] {
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-coklat">
                    <h6 class="m-0 font-weight-bold text-white">Laporan</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('admin/laporancetak') }}" target="_blank">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal Awal</label>
                                    <input type="date" name="tanggalawal" class="form-control" required
                                        onclick="this.showPicker()">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal Akhir</label>
                                    <input type="date" name="tanggalakhir" class="form-control" required
                                        onclick="this.showPicker()">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status Pesanan</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="Belum Bayar">Belum Bayar</option>
                                        <option value="Sudah Upload Bukti Pembayaran DP">Sudah Upload Bukti Pembayaran DP</option>
                                        <option value="Sudah Upload Bukti Pembayaran">Sudah Upload Bukti Pembayaran</option>
                                        <option value="Pesanan Di Terima">Pesanan Di Terima</option>
                                        <option value="Pesanan Sedang Dikirim">Pesanan Sedang Dikirim</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Pesanan Di Tolak">Pesanan Di Tolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Metode Pengiriman</label>
                                    <select name="metode" class="form-control">
                                        <option value="">Semua Metode</option>
                                        <option value="Transfer">Dengan Kurir</option>
                                        <option value="COD">Tanpa Kurir</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" name="cetak" value="cetak" class="btn btn-success float-right"
                                    style="margin-top: 15px">Download Laporan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
