@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <div class="page-header">
        <h1 class="page-title">Laporan Barang Masuk</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Laporan</li>
                <li class="breadcrumb-item active" aria-current="page">Barang Masuk</li>
            </ol>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Data</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="" class="fw-bold">Filter Laporan</label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="tglawal" class="form-control datepicker-date"
                                    placeholder="Tanggal Awal" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="tglakhir" class="form-control datepicker-date"
                                    placeholder="Tanggal Akhir" autocomplete="off">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="filter_jenis" class="form-control">
                                    <option value="">-- Semua Jenis --</option>
                                    @foreach ($jenis as $j)
                                        <option value="{{ $j->jenisbarang_nama }}">{{ $j->jenisbarang_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="search_nama" class="form-control" 
                                    placeholder="Cari Nama Barang..." autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <button class="btn btn-success-light" onclick="filter()"><i class="fe fe-filter"></i>
                                Filter</button>
                            <button class="btn btn-secondary-light" onclick="reset()"><i class="fe fe-refresh-ccw"></i>
                                Reset</button>
                            <button class="btn btn-primary-light" onclick="print()"><i class="fe fe-printer"></i>
                                Print</button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="table-1"
                            class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                            <thead>
                                <th class="border-bottom-0" width="1%">No</th>
                                <th class="border-bottom-0">Tanggal Masuk</th>
                                <th class="border-bottom-0">Kode Masuk</th>
                                <th class="border-bottom-0">Kode Barang</th>
                                <th class="border-bottom-0">Barang</th>
                                <th class="border-bottom-0">Jenis</th> <th class="border-bottom-0">Customer</th>
                                <th class="border-bottom-0">Jumlah</th>
                                <th class="border-bottom-0">SN</th>
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
                    "url": "{{ route('lap-bm.getlap-bm') }}", 
                    "data": function(d) {
                        d.tglawal = $('input[name="tglawal"]').val();
                        d.tglakhir = $('input[name="tglakhir"]').val();
                        d.search_nama = $('input[name="search_nama"]').val();
                        d.filter_jenis = $('select[name="filter_jenis"]').val(); // KIRIM FILTER JENIS
                    }
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'tgl',
                        name: 'bm_tanggal',
                    },
                    {
                        data: 'bm_kode',
                        name: 'bm_kode',
                    },
                    {
                        data: 'barang_kode',
                        name: 'barang_kode',
                    },
                    {
                        data: 'barang', 
                        name: 'barang_nama',
                    },
                    {
                        data: 'jenisbarang_nama', // TAMBAHAN DATA JENIS
                        name: 'tbl_jenisbarang.jenisbarang_nama',
                    },
                    {
                        data: 'customer',
                        name: 'customer_nama',
                    },
                    {
                        data: 'bm_jumlah',
                        name: 'bm_jumlah',
                    },
                    {
                        data: 'code_sn', 
                        name: 'code_sn',
                        defaultContent: '-' 
                    },
                ],
            });
        }

        function filter() {
            table.ajax.reload(null, false);
        }

        function reset() {
            $('input[name="tglawal"]').val('');
            $('input[name="tglakhir"]').val('');
            $('input[name="search_nama"]').val('');
            $('select[name="filter_jenis"]').val(''); // RESET DROPDOWN JENIS
            table.ajax.reload(null, false);
        }

        function print() {
            var tglawal = $('input[name="tglawal"]').val();
            var tglakhir = $('input[name="tglakhir"]').val();
            var search_nama = $('input[name="search_nama"]').val();
            var filter_jenis = $('select[name="filter_jenis"]').val();

            window.open(
                "{{ route('lap-bm.print') }}?tglawal=" + tglawal + "&tglakhir=" + tglakhir + 
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
                "{{ route('lap-bm.pdf') }}?tglawal=" + tglawal + "&tglakhir=" + tglakhir + 
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