@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Profil Saya</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Akun</li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<style>
    .profile-card-header {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        height: 120px;
        position: relative;
    }
    .profile-avatar-wrapper {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
    }
    .avatar-upload {
        width: 100px;
        height: 100px;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        background: #fff;
    }
    .info-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px 15px;
        margin-bottom: 10px;
        border: 1px solid #edf2f7;
    }
    .input-group-text-custom {
        background: #f1f5f9 !important;
        border-right: none !important;
        color: #64748b !important;
    }
    .form-control-custom {
        background: #f8fafc !important;
        border-left: none !important;
    }
    .form-control-custom:focus {
        background: #fff !important;
        border-color: #6366f1 !important;
    }
    .dropzone-area {
        border: 2px dashed #e2e8f0;
        background: #f8fafc;
        transition: all 0.3s ease;
    }
    .dropzone-area:hover {
        border-color: #6366f1;
        background: #f1f5f9;
    }
</style>

<div class="row">
    <div class="col-xl-4">
        <!-- Profile Summary -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="profile-card-header rounded-top">
                <div class="profile-avatar-wrapper">
                    <div class="avatar avatar-upload brround">
                        @if($data->user_foto == 'undraw_profile.svg' || $data->user_foto == '')
                        <img src="{{url('/assets/default/users/undraw_profile.svg')}}" alt="profile-user" class="brround">
                        @else
                        <img src="{{asset('storage/users/'.$data->user_foto)}}" alt="profile-user" class="brround" style="object-fit: cover; width: 100%; height: 100%;">
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body text-center pt-5">
                <h4 class="fw-bold text-dark mt-3 mb-1">{{$data->user_nmlengkap}}</h4>
                <p class="text-primary fw-semibold fs-12 uppercase mb-4">{{$data->role_title}}</p>
                
                <div class="text-start mt-4">
                    <div class="info-box">
                        <small class="text-muted d-block mb-1">Username</small>
                        <span class="text-dark fw-bold"><i class="fe fe-at-sign me-2 text-primary"></i>{{$data->user_nama}}</span>
                    </div>
                    <div class="info-box">
                        <small class="text-muted d-block mb-1">Email</small>
                        <span class="text-dark fw-bold"><i class="fe fe-mail me-2 text-primary"></i>{{$data->user_email}}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Security -->
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom-0 pb-0">
                <h3 class="card-title fw-bold fs-16 text-dark"><i class="fe fe-shield me-2 text-primary"></i>Keamanan Akun</h3>
            </div>
            <form action="{{url('/admin/updatePassword').'/'.$data->user_id}}" method="POST" name="myFormP" onsubmit="return validatePassword()">
                @csrf
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="form-label fs-13 text-muted fw-bold">Password Saat Ini</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-custom"><i class="fe fe-unlock"></i></span>
                            <input class="form-control form-control-custom" name="currentpassword" type="password" placeholder="********">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label fs-13 text-muted fw-bold">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-custom"><i class="fe fe-lock"></i></span>
                            <input class="form-control form-control-custom" name="newpassword" type="password" placeholder="Min. 6 karakter">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label fs-13 text-muted fw-bold">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-custom"><i class="fe fe-check-square"></i></span>
                            <input class="form-control form-control-custom" type="password" name="confirmpassword" placeholder="Ulangi password">
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top-0 pt-0 d-flex justify-content-end gap-2 pb-4">
                    <button type="button" onclick="resetP()" class="btn btn-light px-4">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 box-primary-shadow">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-xl-8">
        <!-- Edit Profile -->
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom-0">
                <h3 class="card-title fw-bold fs-16 text-dark"><i class="fe fe-user-check me-2 text-success"></i>Informasi Data Diri</h3>
            </div>
            <form action="{{url('/admin/updateProfile').'/'.$data->user_id}}" method="POST" name="myFormUpdate" enctype="multipart/form-data" onsubmit="return validateUpdate()">
                @csrf
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fs-13 text-muted fw-bold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="fe fe-edit-3"></i></span>
                                <input type="text" name="nmlengkap" value="{{$data->user_nmlengkap}}" class="form-control form-control-custom" placeholder="John Doe">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label fs-13 text-muted fw-bold">Nama Pengguna</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="fe fe-user"></i></span>
                                <input type="text" name="username" value="{{$data->user_nama}}" class="form-control form-control-custom" placeholder="johndoe">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fs-13 text-muted fw-bold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-custom"><i class="fe fe-mail"></i></span>
                            <input type="email" name="email" value="{{$data->user_email}}" class="form-control form-control-custom" placeholder="john@example.com">
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label fs-13 text-muted fw-bold">Ganti Foto Profil</label>
                        <div class="dropzone-area p-5 rounded-3 text-center">
                            <i class="fe fe-image fs-40 text-muted mb-3 d-block"></i>
                            <h5 class="fs-14 fw-bold text-dark mb-1">Pilih Gambar atau Seret ke Sini</h5>
                            <p class="fs-11 text-muted mb-4">Format: JPG, PNG, SVG (Maks. 3MB)</p>
                            <div class="d-flex justify-content-center">
                                <input class="form-control w-75" id="GetFile" name="photoU" type="file" onchange="VerifyFileNameAndFileSize()" accept=".png,.jpeg,.jpg,.svg">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top-0 d-flex justify-content-end gap-2 pb-4 pt-0">
                    <a href="{{url('/admin/profile')}}/{{Session::get('user')->user_id}}" class="btn btn-light px-4">Reset</a>
                    <button type="submit" class="btn btn-success px-4 box-success-shadow">
                        <i class="fe fe-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function validatePassword() {
        const current = document.forms["myFormP"]["currentpassword"].value;
        const newp = document.forms["myFormP"]["newpassword"].value;
        const confirm = document.forms["myFormP"]["confirmpassword"].value;

        resetValidP();

        if (current == "") {
            validasi('Masukan Password Saat Ini!', 'warning');
            $("input[name='currentpassword']").addClass('is-invalid');
            return false;
        }
        if (newp == "") {
            validasi('Masukan Password Baru!', 'warning');
            $("input[name='newpassword']").addClass('is-invalid');
            return false;
        }
        if (confirm == "") {
            validasi('Masukan Konfirmasi Password!', 'warning');
            $("input[name='confirmpassword']").addClass('is-invalid');
            return false;
        } else if (newp !== '' || confirm !== '') {

            if (newp.length < 6) {
                validasi('Panjang Password minimal 6 karakter!', 'warning');
                $("input[name='newpassword']").addClass('is-invalid');
                $("input[name='confirmpassword']").addClass('is-invalid');
                return false;
            } else if (newp !== confirm) {
                validasi('Konfirmasi Password tidak sesuai!', 'warning');
                $("input[name='newpassword']").addClass('is-invalid');
                $("input[name='confirmpassword']").addClass('is-invalid');
                return false;
            }
        }
    }

    function validateUpdate() {
        const nmlengkap = document.forms["myFormUpdate"]["nmlengkap"].value;
        const username = document.forms["myFormUpdate"]["username"].value;
        const email = document.forms["myFormUpdate"]["email"].value;

        resetValid();

        if (nmlengkap == "") {
            validasi('Nama Lengkap Wajib di isi!', 'warning');
            $("input[name='nmlengkap']").addClass('is-invalid');
            return false;
        } else if (username == "") {
            validasi('Nama User Wajib di isi!', 'warning');
            $("input[name='username']").addClass('is-invalid');
            return false;
        } else if (email == "") {
            validasi('Email Wajib di isi!', 'warning');
            $("input[name='email']").addClass('is-invalid');
            return false;
        }
    }

    function resetValidP() {
        $("input[name='currentpassword']").removeClass('is-invalid');
        $("input[name='newpassword']").removeClass('is-invalid');
        $("input[name='confirmpassword']").removeClass('is-invalid');
    };

    function resetValid() {
        $("input[name='nmlengkap']").removeClass('is-invalid');
        $("input[name='username']").removeClass('is-invalid');
        $("input[name='email']").removeClass('is-invalid');
    };

    function resetP() {
        resetValidP();
        $("input[name='currentpassword']").val('');
        $("input[name='newpassword']").val('');
        $("input[name='confirmpassword']").val('');
    }

    function validasi(judul, status) {
        swal({
            title: judul,
            type: status,
            confirmButtonText: "OK"
        });
    }

    function fileIsValid(fileName) {
        var ext = fileName.match(/\.([^\.]+)$/)[1];
        ext = ext.toLowerCase();
        var isValid = true;
        switch (ext) {
            case 'png':
            case 'jpeg':
            case 'jpg':
            case 'svg':
                break;
            default:
                this.value = '';
                isValid = false;
        }
        return isValid;
    }

    function VerifyFileNameAndFileSize() {
        var file = document.getElementById('GetFile').files[0];


        if (file != null) {
            var fileName = file.name;
            if (fileIsValid(fileName) == false) {
                validasi('Format bukan gambar!', 'warning');
                document.getElementById('GetFile').value = null;
                return false;
            }
            var content;
            var size = file.size;
            if ((size != null) && ((size / (1024 * 1024)) > 3)) {
                validasi('Ukuran maximum 1024px', 'warning');
                document.getElementById('GetFile').value = null;
                return false;
            }

            var ext = fileName.match(/\.([^\.]+)$/)[1];
            ext = ext.toLowerCase();
            // $(".custom-file-label").addClass("selected").html(file.name);
            // document.getElementById('outputImg').src = window.URL.createObjectURL(file);
            return true;

        } else
            return false;
    }
</script>
@endsection