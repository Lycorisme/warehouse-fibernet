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
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-bottom-0 pb-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                    <div>
                        <h3 class="card-title fw-bold fs-18">Daftar Jenis Barang</h3>
                        <p class="text-muted fs-12 mb-0">Kelola dan lihat data kategori barang yang tersedia.</p>
                    </div>
                    @if ($hakTambah > 0)
                        <div class="mt-3 mt-sm-0">
                            <a class="modal-effect btn btn-primary box-primary-shadow px-4 py-2"
                                data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">
                                <i class="fe fe-plus-circle me-2"></i>Tambah Kategori</a>
                        </div>
                    @endif
                </div>
                <div class="card-body pt-4">
                    <div class="table-responsive">
                        <table id="table-1" width="100%"
                            class="table table-hover border-bottom dataTable no-footer">
                            <thead class="bg-light-50">
                                <th class="border-bottom-0 text-muted fw-bold" width="1%">NO</th>
                                <th class="border-bottom-0 text-muted fw-bold" width="10%">KODE</th> 
                                <th class="border-bottom-0 text-muted fw-bold">NAMA KATEGORI</th>
                                <th class="border-bottom-0 text-muted fw-bold">DESKRIPSI</th>
                                <th class="border-bottom-0 text-muted fw-bold text-end" width="1%">ACTION</th>
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