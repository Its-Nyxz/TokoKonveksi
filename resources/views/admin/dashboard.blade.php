@extends('admin.templates.index')

@section('page-content')
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Pesanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPesanan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahUser }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jumlah Stok</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahStok }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pemesanan dan Stok -->
    {{-- <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h3 class="text-center">Grafik Pemesanan dan Stok</h3>
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>
    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('orderChart').getContext('2d');
        var orderChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($combinedLabels) !!},
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: {!! json_encode($combinedOrderData) !!},
                    backgroundColor: 'rgb(34,45,50,1)',
                    borderColor: 'rgb(34,45,50,1)',
                    borderWidth: 1,
                    barThickness: 20,
                    categoryPercentage: 0.4,
                    barPercentage: 0.4
                }, {
                    label: 'Jumlah Stok',
                    data: {!! json_encode($combinedStockData) !!},
                    backgroundColor: 'rgb(163,135,88, 1)',
                    borderColor: 'rgb(163,135,88, 1)',
                    borderWidth: 1,
                    barThickness: 20,
                    categoryPercentage: 0.4,
                    barPercentage: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        ticks: {
                            autoSkip: false,
                            padding: 10
                        },
                        grid: {
                            display: false
                        },
                        offset: true
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
