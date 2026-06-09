@extends('admin.templates.index')

@section('page-content')
    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-coklat">
            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-filter mr-2"></i>Filter Statistik Dashboard</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url('admin') }}">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-2">
                        <label class="font-weight-bold text-dark">Tanggal Awal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}" onclick="this.showPicker()">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="font-weight-bold text-dark">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}" onclick="this.showPicker()">
                    </div>
                    <div class="col-md-4 mb-2 d-flex gap-2">
                        <button type="submit" class="btn btn-secondary flex-fill text-white font-weight-bold"><i class="fas fa-search mr-1"></i>Filter</button>
                        <a href="{{ url('admin') }}" class="btn btn-outline-danger flex-fill font-weight-bold"><i class="fas fa-undo mr-1"></i>Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Card: Jumlah Pesanan -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Pesanan</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $jumlahPesanan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Jumlah User / Member -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Member</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $jumlahUser }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Total Pendapatan (Revenue) -->
        <div class="col-md-4 mb-4">
            <div class="card shadow border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pendapatan</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalRevenue) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Line Chart: Tren Pendapatan -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-coklat text-white font-weight-bold">
                    <i class="fas fa-chart-line mr-2"></i>Tren Pendapatan (Rp)
                </div>
                <div class="card-body">
                    <div style="height: 250px; position: relative;">
                        <canvas id="revenueLineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart: Tren Volume Pemesanan -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-coklat text-white font-weight-bold">
                    <i class="fas fa-chart-bar mr-2"></i>Tren Volume Pemesanan (Pcs)
                </div>
                <div class="card-body">
                    <div style="height: 250px; position: relative;">
                        <canvas id="orderBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart: Distribusi Tipe Pembayaran -->
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 bg-coklat text-white font-weight-bold">
                    <i class="fas fa-chart-pie mr-2"></i>Distribusi Tipe Pembayaran
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div style="height: 250px; width: 250px; position: relative;">
                        <canvas id="paymentPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Line Chart: Pendapatan
        const revCtx = document.getElementById('revenueLineChart').getContext('2d');
        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueLabels) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($revenueValues) !!},
                    borderColor: '#2b5797',
                    backgroundColor: 'rgba(43, 87, 151, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Bar Chart: Volume Pemesanan
        const orderCtx = document.getElementById('orderBarChart').getContext('2d');
        new Chart(orderCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($orderLabels) !!},
                datasets: [{
                    label: 'Volume Pesanan',
                    data: {!! json_encode($orderValues) !!},
                    backgroundColor: '#ffbf0f',
                    borderColor: '#bb8d0f',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Pie Chart: Metode / Tipe Pembayaran
        const pieCtx = document.getElementById('paymentPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($pieLabels) !!},
                datasets: [{
                    data: {!! json_encode($pieValues) !!},
                    backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
