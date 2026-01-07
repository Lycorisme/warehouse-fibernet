@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <div class="page-header">
        <h1 class="page-title">Jenis Barang</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Master Barang</li>
                <li class="breadcrumb-item active" aria-current="page">Jenis Barang</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="counter-icon bg-secondary-gradient box-secondary-shadow text-white me-3">
                            <i class="fe fe-grid"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase fs-12 fw-bold">Total Kategori Jenis</h6>
                            <h3 class="mb-0 number-font fs-24 fw-bold">{{$totalJenis}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-12">
             <div class="card bg-primary-transparent bg-opacity-10 border-0 p-4">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fe fe-info fs-30 text-primary"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-primary mb-1">Manajemen Jenis Barang</h5>
                        <p class="text-muted mb-0 fs-13">Gunakan halaman ini untuk mengelompokkan barang berdasarkan kategorinya agar manajemen stok lebih terorganisir.</p>
                    </div>
                </div>
             </div>
        </div>
    </div>

    <div class="row row-sm mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom-0 pb-0 justify-content-between">
                    <div>
                        <h3 class="card-title fw-bold">Daftar Jenis Barang</h3>
                        <p class="text-muted fs-12 mb-0">Kelola informasi kategori barang Anda di sini.</p>
                    </div>
                    @if ($hakTambah > 0)
                        <div>
                            <a class="modal-effect btn btn-primary box-primary-shadow"
                                data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">
                                <i class="fe fe-plus me-2"></i>Tambah Jenis</a>
                        </div>
                    @endif
                </div>
                <div class="card-body pt-4">
                    <div class="table-responsive">
                        <table id="table-1" width="100%"
                            class="table table-hover text-nowrap border-bottom dataTable no-footer">
                            <thead class="bg-light">
                                <th class="border-bottom-0" width="1%">No</th>
                                <th class="border-bottom-0" width="10%">Kode</th> 
                                <th class="border-bottom-0">Nama Kategori</th>
                                <th class="border-bottom-0">Deskripsi</th>
                                <th class="border-bottom-0" width="1%">Opsi</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Admin.JenisBarang.tambah')
    @include('Admin.JenisBarang.edit')
    @include('Admin.JenisBarang.hapus')

    <script>
        function update(data) {
            $("input[name='idjenisbarangU']").val(data.jenisbarang_id);
            // TAMBAHAN: Isi field Kode di modal edit
            $("input[name='kodeU']").val(data.jenis_initial); 
            
            $("input[name='jenisbarangU']").val(data.jenisbarang_nama.replace(/_/g, ' '));
            $("textarea[name='ketU']").val(data.jenisbarang_ket.replace(/_/g, ' '));
        }

        function hapus(data) {
            $("input[name='idjenisbarang']").val(data.jenisbarang_id);
            $("#vjenisbarang").html("jenis " + "<b>" + data.jenisbarang_nama.replace(/_/g, ' ') + "</b>");
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

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table;
        $(document).ready(function() {
            //datatables
            table = $('#table-1').DataTable({

                "processing": true,
                "serverSide": true,
                "info": true,
                "stateSave":true,
                "order": [],
                "lengthMenu": [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                "pageLength": 10,

                lengthChange: true,

                "ajax": {
                    "url": "{{ route('jenisbarang.getjenisbarang') }}",
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    // TAMBAHAN KOLOM KODE DI DATA TABLES
                    {
                        data: 'jenis_initial',
                        name: 'jenis_initial',
                    },
                    {
                        data: 'jenisbarang_nama',
                        name: 'jenisbarang_nama',
                    },
                    {
                        data: 'ket',
                        name: 'jenisbarang_ket',
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
    </script>
@endsection