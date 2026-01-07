@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Pengaturan Website</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Admin</li>
            <li class="breadcrumb-item active" aria-current="page">Pengaturan Website</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<div class="row mt-4">
    <div class="col-12 col-md-12 col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header border-bottom-0 pb-0">
                <h3 class="card-title fw-bold fs-18">Profil Instansi</h3>
                <p class="text-muted fs-12 mb-0">Identitas utama website yang akan ditampilkan ke publik.</p>
            </div>
            <div class="card-body pt-4">
                @foreach($data as $d)
                <div class="text-center py-4 mb-4 bg-light rounded-3 position-relative overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary opacity-5" style="z-index: 0;"></div>
                    <div class="position-relative" style="z-index: 1;">
                        @if($d->web_logo == '' || $d->web_logo == 'default.png')
                        <img src="{{ url('assets/default/web/default.png') }}" alt="logo" width="140" class="img-fluid drop-shadow-sm">
                        @else
                        <img src="{{asset('storage/web/' . $d->web_logo)}}" alt="logo" width="140" class="img-fluid drop-shadow-sm">
                        @endif
                    </div>
                </div>
                @endforeach

                <div class="list-group list-group-flush border-top-0">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <span class="text-muted fw-semibold">Nama Website</span>
                        <span class="text-dark fw-bold fs-15">{{$d->web_nama}}</span>
                    </div>
                    <div class="list-group-item d-flex flex-column px-0 py-3 border-bottom-0">
                        <span class="text-muted fw-semibold mb-2">Teks Footer Website</span>
                        <p class="text-dark mb-0 fs-14 leading-relaxed">{{$d->web_footer == "" ? "Tidak ada footer." : $d->web_footer}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-12 col-lg-6 mb-4">
        <form action="{{ route('web.update', $d->web_id) }}" method="POST" name="myForm" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-bottom-0 pb-0">
                    <h3 class="card-title fw-bold fs-18">Konfigurasi Website</h3>
                    <p class="text-muted fs-12 mb-0">Sesuaikan nama, logo, dan deskripsi sistem Anda.</p>
                </div>
                <div class="card-body pt-4">
                    <div class="alert bg-primary-transparent border-primary-50 text-primary d-flex align-items-center rounded-3 mb-4" role="alert">
                        <i class="fe fe-info me-3 fs-20"></i>
                        <div class="fs-12">
                            <strong class="d-block mb-1">Ketentuan Gambar:</strong>
                            Format diperbolehkan: .jpg, .jpeg, .png, .svg. Ukuran maksimal 3MB.
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold text-muted fs-12 mb-1">Unggah Logo Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fe fe-image text-muted"></i></span>
                            <input class="form-control border-start-0" id="GetFile" name="photo" type="file" accept=".png,.jpeg,.jpg,.svg" onchange="VerifyFileNameAndFileSize()">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold text-muted fs-12 mb-1">Nama Aplikasi / Website</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fe fe-globe text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" name="nmweb" value="{{$d->web_nama}}" placeholder="Masukkan nama website">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-bold text-muted fs-12 mb-1">Deskripsi & Meta Data</label>
                        <textarea name="desk" rows="3" class="form-control" placeholder="Tuliskan deskripsi singkat mengenai website ini...">{{$d->web_deskripsi}}</textarea>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label fw-bold text-muted fs-12 mb-1">Teks Footer</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fe fe-type text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" name="footer" value="{{$d->web_footer}}" placeholder="Contoh: Digital Agency">
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top-0 pt-0 pb-4 mt-auto">
                    <button type="submit" class="btn btn-primary btn-md box-primary-shadow px-4 w-100 py-2">
                        <i class="fe fe-save me-2"></i> Simpan Seluruh Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function validateForm() {
        var nmweb = document.forms["myForm"]["nmweb"].value;

        if (nmweb == "") {
            validasi('Judul Website wajib di isi!', 'warning');
            $("input[name='nmweb']").addClass('is-invalid');
            return false;
        }

    }

    function validasi(judul, status) {
        swal({
            title: judul,
            type: status,
            confirmButtonText: "Iya."
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
            return true;

        } else
            return false;
    }
</script>
@endsection