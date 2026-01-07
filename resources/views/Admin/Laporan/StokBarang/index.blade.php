@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <div class="page-header">
        <h1 class="page-title">Laporan Stok Barang</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Laporan</li>
                <li class="breadcrumb-item active" aria-current="page">Stok Barang</li>
            </ol>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-bottom-0 pb-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                    <div>
                        <h3 class="card-title fw-bold fs-18">Laporan Mutasi & Stok Barang</h3>
                        <p class="text-muted fs-12 mb-0">Lihat ringkasan stok awal, mutasi barang (masuk/keluar), dan total stok akhir secara real-time.</p>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="bg-light p-4 rounded-3 mb-4 section-filter">
                        <div class="row g-3">
                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-0"><i class="fe fe-filter me-2 text-primary"></i>Filter Laporan</h6>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label class="fs-12 fw-bold text-muted mb-1">Tanggal Awal</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="fe fe-calendar text-muted"></i></span>
                                        <input type="text" name="tglawal" class="form-control datepicker-date border-start-0"
                                            placeholder="Pilih Tanggal" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label class="fs-12 fw-bold text-muted mb-1">Tanggal Akhir</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="fe fe-calendar text-muted"></i></span>
                                        <input type="text" name="tglakhir" class="form-control datepicker-date border-start-0"
                                            placeholder="Pilih Tanggal" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label class="fs-12 fw-bold text-muted mb-1">Kategori Barang</label>
                                    <select name="filter_jenis" class="form-control select2">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($jenis as $j)
                                            <option value="{{ $j->jenisbarang_nama }}">{{ $j->jenisbarang_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label class="fs-12 fw-bold text-muted mb-1">Cari Barang</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="fe fe-search text-muted"></i></span>
                                        <input type="text" name="search_nama" class="form-control border-start-0" 
                                            placeholder="Nama barang..." autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3 d-flex gap-2">
                                <button class="btn btn-primary px-4" onclick="filter()"><i class="fe fe-check-circle me-2"></i>Terapkan Filter</button>
                                <button class="btn btn-outline-secondary px-4" onclick="reset()"><i class="fe fe-refresh-cw me-2"></i>Reset</button>
                                <button class="btn btn-outline-danger px-4" onclick="print()"><i class="fe fe-printer me-2"></i>Print Mutasi</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="table-1" width="100%"
                            class="table table-hover border-bottom dataTable no-footer">
                            <thead class="bg-light-50">
                                <th class="border-bottom-0 text-muted fw-bold" width="1%">NO</th>
                                <th class="border-bottom-0 text-muted fw-bold">KODE BARANG</th>
                                <th class="border-bottom-0 text-muted fw-bold">NAMA BARANG</th>
                                <th class="border-bottom-0 text-muted fw-bold">JENIS</th>
                                <th class="border-bottom-0 text-muted fw-bold text-center">STOK AWAL</th>
                                <th class="border-bottom-0 text-muted fw-bold text-center text-success">MASUK</th>
                                <th class="border-bottom-0 text-muted fw-bold text-center text-danger">KELUAR</th>
                                <th class="border-bottom-0 text-muted fw-bold text-center">STOK AKHIR</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            getData();

            $('input[name="search_nama"]').on('keyup search', function() {
                if ($(this).val() == '') {
                    table.ajax.reload(null, false);
                }
            });
        });

        function getData() {
            table = $('#table-1').DataTable({
                "processing": true,
                "serverSide": true,
                "info": true,
                "order": [],
                "scrollX": true,
                "stateSave": true,
                "lengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, 'Semua']
                ],
                "pageLength": 10,
                lengthChange: true,
                "ajax": {
                    "url": "{{ route('lap-sb.getlap-sb') }}",
                    "data": function(d) {
                        d.tglawal = $('input[name="tglawal"]').val();
                        d.tglakhir = $('input[name="tglakhir"]').val();
                        d.search_nama = $('input[name="search_nama"]').val();
                        d.filter_jenis = $('select[name="filter_jenis"]').val(); // Tambahkan parameter ini
                    }
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'barang_kode',
                        name: 'barang_kode',
                    },
                    {
                        data: 'barang_nama',
                        name: 'barang_nama',
                    },
                    {
                        data: 'jenisbarang_nama',
                        name: 'jenisbarang_nama'
                    },
                    {
                        data: 'stokawal',
                        name: 'barang_stok',
                    },
                    {
                        data: 'jmlmasuk',
                        name: 'barang_kode',
                        orderable: false,
                    },
                    {
                        data: 'jmlkeluar',
                        name: 'barang_kode',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'totalstok',
                        name: 'barang_kode',
                        searchable: false,
                        orderable: false,
                    },
                ],
            });
        }

        function filter() {
            var tglawal = $('input[name="tglawal"]').val();
            var tglakhir = $('input[name="tglakhir"]').val();
            var search_nama = $('input[name="search_nama"]').val();
            var filter_jenis = $('select[name="filter_jenis"]').val();

            // Validasi: Reload jika ada salah satu filter yang terisi
            if ((tglawal != '' && tglakhir != '') || search_nama != '' || filter_jenis != '') {
                table.ajax.reload(null, false);
            } else {
                table.ajax.reload(null, false);
            }
        }

        function reset() {
            $('input[name="tglawal"]').val('');
            $('input[name="tglakhir"]').val('');
            $('input[name="search_nama"]').val('');
            $('select[name="filter_jenis"]').val(''); // Reset dropdown jenis
            table.ajax.reload(null, false);
        }

        function print() {
            var tglawal = $('input[name="tglawal"]').val();
            var tglakhir = $('input[name="tglakhir"]').val();
            var search_nama = $('input[name="search_nama"]').val();
            var filter_jenis = $('select[name="filter_jenis"]').val();

            window.open(
                "{{ route('lap-sb.print') }}?tglawal=" + tglawal + "&tglakhir=" + tglakhir + 
                "&search_nama=" + search_nama + "&filter_jenis=" + filter_jenis,
                '_blank'
            );
        }

        function pdf() {
            var tglawal = $('input[name="tglawal"]').val();
            var tglakhir = $('input[name="tglakhir"]').val();
            var search_nama = $('input[name="search_nama"]').val();
            var filter_jenis = $('select[name="filter_jenis"]').val();

            window.open(
                "{{ route('lap-sb.pdf') }}?tglawal=" + tglawal + "&tglakhir=" + tglakhir + 
                "&search_nama=" + search_nama + "&filter_jenis=" + filter_jenis,
                '_blank'
            );
        }

        function validasi(judul, status) {
            swal({
                title: judul,
                type: status,
                confirmButtonText: "Iya."
            });
        }
    </script>
@endsection