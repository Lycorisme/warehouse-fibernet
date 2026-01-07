@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Dashboard Utama</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Admin</li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- STATS CARDS -->
<div class="row">
    <!-- ROW 1: MASTER DATA -->
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="{{url('/admin/barang')}}" class="card overflow-hidden card-link">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="counter-icon bg-primary-gradient box-primary-shadow text-white me-3">
                        <i class="fe fe-package"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Data Barang</h6>
                        <h3 class="mb-0 number-font fs-24 fw-bold">{{$barang}}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="{{url('/admin/jenisbarang')}}" class="card overflow-hidden card-link">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="counter-icon bg-secondary-gradient box-secondary-shadow text-white me-3">
                        <i class="fe fe-grid"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Jenis Barang</h6>
                        <h3 class="mb-0 number-font fs-24 fw-bold">{{$jenis}}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="{{url('/admin/satuan')}}" class="card overflow-hidden card-link">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="counter-icon bg-info-gradient box-info-shadow text-white me-3">
                        <i class="fe fe-layers"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Satuan Barang</h6>
                        <h3 class="mb-0 number-font fs-24 fw-bold">{{$satuan}}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="{{url('/admin/merk')}}" class="card overflow-hidden card-link">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="counter-icon bg-purple-gradient box-purple-shadow text-white me-3">
                        <i class="fe fe-tag"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Merk Barang</h6>
                        <h3 class="mb-0 number-font fs-24 fw-bold">{{$merk}}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- ROW 2: TRANSACTIONS & USERS -->
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="{{url('/admin/barang-masuk')}}" class="card overflow-hidden card-link">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="counter-icon bg-success-gradient box-success-shadow text-white me-3">
                        <i class="fe fe-arrow-down-left"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Barang Masuk</h6>
                        <h3 class="mb-0 number-font fs-24 fw-bold">{{$bm}}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="{{url('/admin/barang-keluar')}}" class="card overflow-hidden card-link">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="counter-icon bg-danger-gradient box-danger-shadow text-white me-3">
                        <i class="fe fe-arrow-up-right"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Barang Keluar</h6>
                        <h3 class="mb-0 number-font fs-24 fw-bold">{{$bk}}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="{{url('/admin/customer')}}" class="card overflow-hidden card-link">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="counter-icon bg-warning-gradient box-warning-shadow text-white me-3">
                        <i class="fe fe-users"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Total Supplier</h6>
                        <h3 class="mb-0 number-font fs-24 fw-bold">{{$customer}}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
        <a href="{{url('/admin/user')}}" class="card overflow-hidden card-link">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="counter-icon bg-dark-gradient box-dark-shadow text-white me-3">
                        <i class="fe fe-user"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Total User</h6>
                        <h3 class="mb-0 number-font fs-24 fw-bold">{{$user}}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- CHARTS AND ALERTS -->
<div class="row">
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Statistik Transaksi Bulanan</h3>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height:320px;">
                    <canvas id="transactionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header bg-danger-transparent bg-opacity-10">
                <h3 class="card-title text-danger fw-bold"><i class="fe fe-alert-triangle me-2"></i>Stok Menipis</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap mb-0 table-striped">
                        <tbody>
                            @forelse($low_stock as $ls)
                            <tr>
                                <td class="p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light p-2 rounded me-3">
                                            <i class="fe fe-package text-muted"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold fs-13">{{$ls->barang_nama}}</div>
                                            <div class="text-muted fs-11">{{$ls->barang_kode}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end p-3">
                                    <span class="badge bg-danger rounded-pill px-3">{{$ls->barang_stok}} Unit</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center p-4">Semua stok aman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{url('admin/barang')}}" class="text-primary fs-12 fw-bold">Lihat Semua Barang <i class="fe fe-chevron-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- RECENT TABLES -->
<div class="row">
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h3 class="card-title">Barang Masuk Terbaru</h3>
                    <a href="{{url('admin/barang-masuk')}}" class="btn btn-sm btn-primary-light">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr class="fs-12 text-muted text-uppercase">
                                <th class="border-bottom-0">Kode</th>
                                <th class="border-bottom-0">Barang</th>
                                <th class="border-bottom-0">Jumlah</th>
                                <th class="border-bottom-0">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_bm as $rbm)
                            <tr class="fs-13">
                                <td class="fw-bold text-primary">{{$rbm->bm_kode}}</td>
                                <td>{{$rbm->barang_nama}}</td>
                                <td><span class="text-success fw-bold">+{{$rbm->bm_jumlah}}</span></td>
                                <td class="text-muted">{{$rbm->bm_tanggal}}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h3 class="card-title">Barang Keluar Terbaru</h3>
                    <a href="{{url('admin/barang-keluar')}}" class="btn btn-sm btn-danger-light">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap mb-0">
                        <thead>
                            <tr class="fs-12 text-muted text-uppercase">
                                <th class="border-bottom-0">Kode</th>
                                <th class="border-bottom-0">Barang</th>
                                <th class="border-bottom-0">Jumlah</th>
                                <th class="border-bottom-0">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_bk as $rbk)
                            <tr class="fs-13">
                                <td class="fw-bold text-danger">{{$rbk->bk_kode}}</td>
                                <td>{{$rbk->barang_nama}}</td>
                                <td><span class="text-danger fw-bold">-{{$rbk->bk_jumlah}}</span></td>
                                <td class="text-muted">{{$rbk->bk_tanggal}}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-gradient { background: linear-gradient(to bottom right, #4454c3 0%, #2d3dab 100%) !important; }
    .bg-success-gradient { background: linear-gradient(to bottom right, #2dce89 0%, #21af72 100%) !important; }
    .bg-danger-gradient { background: linear-gradient(to bottom right, #f5334f 0%, #d81b37 100%) !important; }
    .bg-warning-gradient { background: linear-gradient(to bottom right, #ffab00 0%, #e69a00 100%) !important; }
    .bg-secondary-gradient { background: linear-gradient(to bottom right, #c344ad 0%, #ab2d8e 100%) !important; }
    .bg-info-gradient { background: linear-gradient(to bottom right, #17a2b8 0%, #117a8b 100%) !important; }
    .bg-purple-gradient { background: linear-gradient(to bottom right, #702785 0%, #531c62 100%) !important; }
    .bg-dark-gradient { background: linear-gradient(to bottom right, #343a40 0%, #1d2124 100%) !important; }
    
    .card-link {
        transition: all 0.3s ease;
        text-decoration: none !important;
    }
    
    .card-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    
    .counter-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: none;
        margin-bottom: 30px;
    }
    
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid #f0f0f2;
        padding: 1.25rem;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("transactionChart").getContext('2d');
        
        var gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient1.addColorStop(0, 'rgba(68, 84, 195, 0.8)');
        gradient1.addColorStop(1, 'rgba(68, 84, 195, 0.05)');
        
        var gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient2.addColorStop(0, 'rgba(245, 51, 79, 0.8)');
        gradient2.addColorStop(1, 'rgba(245, 51, 79, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chart_months) !!},
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: {!! json_encode($chart_bm) !!},
                        borderColor: '#4454c3',
                        backgroundColor: gradient1,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4454c3',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Barang Keluar',
                        data: {!! json_encode($chart_bk) !!},
                        borderColor: '#f5334f',
                        backgroundColor: gradient2,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#f5334f',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: '#f0f0f2'
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#8e9cad'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11 },
                            color: '#8e9cad'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 12,
                            padding: 20,
                            font: { size: 12, weight: '600' }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
