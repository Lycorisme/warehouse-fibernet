@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Role</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Settings</li>
            <li class="breadcrumb-item text-gray">User</li>
            <li class="breadcrumb-item active" aria-current="page">Role</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- Row -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom-0 pb-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                <div>
                    <h3 class="card-title fw-bold fs-18">Manajemen Role</h3>
                    <p class="text-muted fs-12 mb-0">Kelola peran dan hak akses pengguna dalam sistem.</p>
                </div>
                <div>
                    <a class="modal-effect btn btn-primary box-primary-shadow px-4 py-2" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">
                        <i class="fe fe-plus-circle me-2"></i> Tambah Role
                    </a>
                </div>
            </div>
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table id="table-1" width="100%" class="table table-hover border-bottom dataTable no-footer">
                        <thead class="bg-light-50">
                            <th class="border-bottom-0 text-muted fw-bold" width="1%">NO</th>
                            <th class="border-bottom-0 text-muted fw-bold">TITLE</th>
                            <th class="border-bottom-0 text-muted fw-bold">SLUG</th>
                            <th class="border-bottom-0 text-muted fw-bold">DESCRIPTION</th>
                            <th class="border-bottom-0 text-muted fw-bold text-end" width="1%">ACTION</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

@include('Master.Role.tambah')
@include('Master.Role.ubah')
@include('Master.Role.hapus')

<script>
    function update(data) {
        $("#myFormU").attr("action", "{{url('/admin/role')}}/" + data.role_id);
        $("input[name='utitle']").val(data.role_title.replace(/_/g, ' '));
        $("textarea[name='udesc']").val(data.role_desc.replace(/_/g, ' '));
    }

    function hapus(data) {
        $("input[name='idrole']").val(data.role_id);
        $("#vrole").html("role "+"<b>"+data.role_title+"</b>");
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
    var table;
    $(document).ready(function() {
        //datatables
        table = $('#table-1').DataTable({

            "processing": true,
            "serverSide": true,
            "info": true,
            "order": [],
            "lengthMenu": [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            "pageLength": 10,

            lengthChange: true,

            "ajax": {
                "url": "{{route('role.getrole')}}",
            },

            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'role_title',
                    name: 'role_title',
                },
                {
                    data: 'role_slug',
                    name: 'role_slug',
                },
                {
                    data: 'role_desc',
                    name: 'role_desc'
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