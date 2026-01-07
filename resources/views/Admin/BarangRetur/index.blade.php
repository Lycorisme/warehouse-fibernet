@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <div class="page-header">
        <h1 class="page-title">Barang Retur</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Transaksi</li>
                <li class="breadcrumb-item active" aria-current="page">Barang Retur</li>
            </ol>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Data Barang Retur</h3>
                    @if ($hakTambah > 0)
                        <div>
                            <a class="modal-effect btn btn-primary-light" onclick="generateID()"
                                data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">Tambah Data
                                <i class="fe fe-plus"></i></a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-1"
                            class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                            <thead>
                                <th class="border-bottom-0" width="1%">No</th>
                                <th class="border-bottom-0">Tanggal Retur</th>
                                <th class="border-bottom-0">Kode Retur</th>
                                <th class="border-bottom-0">Kode Barang</th>
                                <th class="border-bottom-0">Barang</th>
                                <th class="border-bottom-0">Jumlah</th>
                                <th class="border-bottom-0">Keterangan</th>
                                <th class="border-bottom-0" width="1%">Action</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Admin.BarangRetur.tambah')
    @include('Admin.BarangRetur.edit')
    @include('Admin.BarangRetur.hapus')
    @include('Admin.BarangRetur.barang')

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#table-1').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('barang-retur.getbarang-retur') }}", // Pastikan nama route ini benar di web.php
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'tgl',
                        name: 'retur_tanggal',
                    },
                    {
                        data: 'retur_kode',
                        name: 'retur_kode',
                    },
                    {
                        data: 'barang_kode',
                        name: 'barang_kode',
                    },
                    {
                        data: 'barang', // Dari addColumn Controller
                        name: 'barang_nama',
                    },
                    {
                        data: 'retur_jumlah',
                        name: 'retur_jumlah',
                    },
                    {
                        data: 'keterangan', // Dari addColumn Controller (alias untuk retur_keterangan)
                        name: 'retur_keterangan',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });

        function generateID() {
            try {
                reset(); 
            } catch (e) {}
            
            var id = Math.floor(Math.random() * 1000);
            $('input[name="returkode"]').val("BRT-" + id);
            $('#modaldemo8').modal('show');
        }
    </script>

    @yield('formTambahJS')
    @yield('formEditJS')
    @yield('formHapusJS')
    @yield('formBarangJS')
@endsection