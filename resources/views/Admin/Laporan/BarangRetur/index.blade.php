@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <div class="page-header">
        <h1 class="page-title">Laporan Barang Retur</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Laporan</li>
                <li class="breadcrumb-item active" aria-current="page">Barang Retur</li>
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
                                <input type="text" name="tglawal" class="form-control datepicker-date" placeholder="Tanggal Awal" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="tglakhir" class="form-control datepicker-date" placeholder="Tanggal Akhir" autocomplete="off">
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
                                <input type="text" name="search_nama" class="form-control" placeholder="Cari Nama Barang..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <button class="btn btn-success-light" onclick="filter()"><i class="fe fe-filter"></i> Filter</button>
                            <button class="btn btn-secondary-light" onclick="reset()"><i class="fe fe-refresh-ccw"></i> Reset</button>
                            <button class="btn btn-primary-light" onclick="print()"><i class="fe fe-printer"></i> Print</button>
                            {{-- <button class="btn btn-danger-light" onclick="pdf()"><i class="fe fe-file-text"></i> PDF</button> --}}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-1" class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Tanggal Retur</th>
                                    <th>Kode Retur</th>
                                    <th>Kode Barang</th>
                                    <th>Barang</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
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
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        var table;
        $(document).ready(function() {
            getData();
            $('input[name="search_nama"]').on('keyup search', function() {
                if ($(this).val() == '') table.ajax.reload(null, false);
            });
        });

        function getData() {
            table = $('#table-1').DataTable({
                "processing": true, "serverSide": true, "scrollX": true,
                "ajax": {
                    "url": "{{ route('lap-retur.getlap-retur') }}",
                    "data": function(d) {
                        d.tglawal = $('input[name="tglawal"]').val();
                        d.tglakhir = $('input[name="tglakhir"]').val();
                        d.search_nama = $('input[name="search_nama"]').val();
                        d.filter_jenis = $('select[name="filter_jenis"]').val();
                    }
                },
                "columns": [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    { data: 'tgl', name: 'retur_tanggal' },
                    { data: 'retur_kode', name: 'retur_kode' },
                    { data: 'barang_kode', name: 'barang_kode' },
                    { data: 'barang', name: 'tbl_barang.barang_nama' },
                    { data: 'jenisbarang_nama', name: 'tbl_jenisbarang.jenisbarang_nama' },
                    { data: 'retur_jumlah', name: 'retur_jumlah' },
                    { data: 'retur_keterangan', name: 'retur_keterangan', defaultContent: '-' },
                ],
            });
        }

        function filter() { table.ajax.reload(null, false); }
        function reset() {
            $('.form-control').val('');
            table.ajax.reload(null, false);
        }

        function print() {
            var params = "?tglawal=" + $('input[name="tglawal"]').val() + "&tglakhir=" + $('input[name="tglakhir"]').val() + "&search_nama=" + $('input[name="search_nama"]').val() + "&filter_jenis=" + $('select[name="filter_jenis"]').val();
            window.open("{{ route('lap-retur.print') }}" + params, '_blank');
        }

        function pdf() {
            var params = "?tglawal=" + $('input[name="tglawal"]').val() + "&tglakhir=" + $('input[name="tglakhir"]').val() + "&search_nama=" + $('input[name="search_nama"]').val() + "&filter_jenis=" + $('select[name="filter_jenis"]').val();
            window.open("{{ route('lap-retur.pdf') }}" + params, '_blank');
        }
    </script>
@endsection