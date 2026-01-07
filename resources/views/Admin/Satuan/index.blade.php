@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <div class="page-header">
        <h1 class="page-title">Satuan Barang</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Master Barang</li>
                <li class="breadcrumb-item active" aria-current="page">Satuan Barang</li>
            </ol>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-bottom-0 pb-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                    <div>
                        <h3 class="card-title fw-bold fs-18">Daftar Satuan Barang</h3>
                        <p class="text-muted fs-12 mb-0">Kelola dan lihat data satuan barang yang tersedia.</p>
                    </div>
                    @if ($hakTambah > 0)
                        <div class="mt-3 mt-sm-0">
                            <a class="modal-effect btn btn-primary box-primary-shadow px-4 py-2"
                                data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">
                                <i class="fe fe-plus-circle me-2"></i>Tambah Satuan</a>
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
                                <th class="border-bottom-0 text-muted fw-bold">SATUAN</th>
                                <th class="border-bottom-0 text-muted fw-bold">KETERANGAN</th>
                                <th class="border-bottom-0 text-muted fw-bold text-end" width="1%">ACTION</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Admin.Satuan.tambah')
    @include('Admin.Satuan.edit')
    @include('Admin.Satuan.hapus')

    <script>
        function update(data) {
            $("input[name='idsatuanU']").val(data.satuan_id);
            // TAMBAHAN: Isi field Kode di modal edit (ambil dari satuan_initial)
            $("input[name='kodeU']").val(data.satuan_initial);
            
            $("input[name='satuanU']").val(data.satuan_nama.replace(/_/g, ' '));
            $("textarea[name='ketU']").val(data.satuan_keterangan.replace(/_/g, ' '));
        }

        function hapus(data) {
            $("input[name='idsatuan']").val(data.satuan_id);
            $("#vsatuan").html("satuan " + "<b>" + data.satuan_nama.replace(/_/g, ' ') + "</b>");
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
                "order": [],
                "stateSave": true,
                "lengthMenu": [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                "pageLength": 10,

                lengthChange: true,

                "ajax": {
                    "url": "{{ route('satuan.getsatuan') }}",
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    // TAMBAHAN KOLOM DATA TABLES
                    {
                        data: 'satuan_initial',
                        name: 'satuan_initial',
                    },
                    {
                        data: 'satuan_nama',
                        name: 'satuan_nama',
                    },
                    {
                        data: 'ket',
                        name: 'satuan_keterangan',
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