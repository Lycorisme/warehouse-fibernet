@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Supplier</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Admin</li>
                <li class="breadcrumb-item active" aria-current="page">Supplier</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->


    <!-- ROW -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-bottom-0 pb-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                    <div>
                        <h3 class="card-title fw-bold fs-18">Daftar Supplier</h3>
                        <p class="text-muted fs-12 mb-0">Kelola informasi supplier dan mitra bisnis Anda.</p>
                    </div>
                    @if ($hakTambah > 0)
                        <div class="mt-3 mt-sm-0 d-flex gap-2">
                            <button class="btn btn-outline-primary px-4 py-2" onclick="printWindow()">
                                <i class="fe fe-printer me-2"></i>Print Laporan</button>
                            <a class="modal-effect btn btn-primary box-primary-shadow px-4 py-2" data-bs-effect="effect-super-scaled"
                                data-bs-toggle="modal" href="#modaldemo8">
                                <i class="fe fe-plus-circle me-2"></i>Tambah Supplier</a>
                        </div>
                    @endif
                </div>
                <div class="card-body pt-4">
                    <div class="table-responsive">
                        <table id="table-1" width="100%"
                            class="table table-hover border-bottom dataTable no-footer">
                            <thead class="bg-light-50">
                                <th class="border-bottom-0 text-muted fw-bold" width="1%">NO</th>
                                <th class="border-bottom-0 text-muted fw-bold">SUPPLIER</th>
                                <th class="border-bottom-0 text-muted fw-bold">NO TELP</th>
                                <th class="border-bottom-0 text-muted fw-bold">ALAMAT</th>
                                <th class="border-bottom-0 text-muted fw-bold text-end" width="1%">ACTION</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

    @include('Admin.Customer.tambah')
    @include('Admin.Customer.edit')
    @include('Admin.Customer.hapus')

    <script>
        function update(data) {
            $("input[name='idcustomerU']").val(data.customer_id);
            $("input[name='customerU']").val(data.customer_nama.replace(/_/g, ' '));
            $("input[name='notelpU']").val(data.customer_notelp);
            $("textarea[name='alamatU']").val(data.customer_alamat.replace(/_/g, ' '));
        }

        function hapus(data) {
            $("input[name='idcustomer']").val(data.customer_id);
            $("#vcustomer").html("Supplier " + "<b>" + data.customer_nama.replace(/_/g, ' ') + "</b>");
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
                    "url": "{{ route('customer.getcustomer') }}",
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'customer_nama',
                        name: 'customer_nama',
                    },
                    {
                        data: 'notelp',
                        name: 'customer_notelp',
                    },
                    {
                        data: 'alamat',
                        name: 'customer_alamat',
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

        function printWindow() {
            window.open("{{ route('lap-customer.print') }}", '_blank');
        }
    </script>
@endsection
