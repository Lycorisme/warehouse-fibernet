@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">User</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Settings</li>
                <li class="breadcrumb-item text-gray">User</li>
                <li class="breadcrumb-item active" aria-current="page">List</li>
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
                        <h3 class="card-title fw-bold fs-18">Manajemen Pengguna</h3>
                        <p class="text-muted fs-12 mb-0">Kelola akun pengguna, hak akses, dan profil dalam sistem.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a class="modal-effect btn btn-primary box-primary-shadow px-4 py-2" data-bs-effect="effect-super-scaled"
                            data-bs-toggle="modal" href="#modaldemo8">
                            <i class="fe fe-plus-circle me-2"></i> Tambah User</a>
                        <button class="btn btn-outline-danger px-4" onclick="printWindow()"><i class="fe fe-printer me-2"></i>Print PDF</button>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="table-responsive">
                        <table id="table-1" width="100%"
                            class="table table-hover border-bottom dataTable no-footer">
                            <thead class="bg-light-50">
                                <th class="border-bottom-0 text-muted fw-bold" width="1%">NO</th>
                                <th class="border-bottom-0 text-muted fw-bold">FOTO</th>
                                <th class="border-bottom-0 text-muted fw-bold">NAMA LENGKAP</th>
                                <th class="border-bottom-0 text-muted fw-bold">USERNAME</th>
                                <th class="border-bottom-0 text-muted fw-bold">EMAIL</th>
                                <th class="border-bottom-0 text-muted fw-bold">ROLE</th>
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

    @include('Master.User.tambah', ['role' => $role])
    @include('Master.User.ubah', ['role' => $role])
    @include('Master.User.hapus')

    <script>
        function update(data) {
            $("#myFormU").attr("action", "{{ url('/admin/user') }}/" + data.user_id);
            $("input[name='nmlengkapU']").val(data.user_nmlengkap.replace(/_/g, ' '));
            $("input[name='usernameU']").val(data.user_nama.replace(/_/g, ' '));
            $("input[name='emailU']").val(data.user_email);
            $("select[name='roleU']").val(data.role_id);
            $("input[name='flama']").val(data.user_foto);
            if (data.user_foto != 'undraw_profile.svg') {
                $("#outputImgU").attr("src", "{{ asset('storage/users/') }}" + "/" + data.user_foto);
            }
        }

        function hapus(data) {
            $("input[name='iduser']").val(data.user_id);
            $("#vuser").html("user " + "<b>" + data.user_nama + "</b>");
        }

        function validasi(judul, status) {
            swal({
                title: judul,
                type: status,
                confirmButtonText: "Iya."
            });
        }

        function printWindow() {
            window.open("{{ route('lap-user.print') }}", '_blank');
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
                    "url": "{{ route('user.getuser') }}",
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'img',
                        name: 'user_foto',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'user_nmlengkap',
                        name: 'user_nmlengkap',
                    },
                    {
                        data: 'user_nama',
                        name: 'user_nama',
                    },
                    {
                        data: 'user_email',
                        name: 'user_email',
                    },
                    {
                        data: 'role',
                        name: 'role_title'
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
