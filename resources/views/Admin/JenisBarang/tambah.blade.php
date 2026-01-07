<div class="modal fade" data-bs-backdrop="static" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark px-2 pt-3">Tambah Kategori Baru</h5>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group mb-4">
                    <label for="kode" class="form-label fw-semibold mb-2">Kode Initial <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control form-control-lg fs-14 border-0 bg-light" placeholder="Cth: 01" maxlength="2" onkeypress="return isNumber(event)" style="border-radius: 10px;">
                    <small class="text-muted mt-2 d-block">Gunakan 2 digit angka sebagai identitas unik.</small>
                </div>

                <div class="form-group mb-4">
                    <label for="jenisbarang" class="form-label fw-semibold mb-2">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="jenisbarang" class="form-control form-control-lg fs-14 border-0 bg-light" placeholder="Cth: Elektronik" style="border-radius: 10px;">
                </div>
                <div class="form-group mb-0">
                    <label for="ket" class="form-label fw-semibold mb-2">Deskripsi Singkat</label>
                    <textarea name="ket" class="form-control border-0 bg-light" rows="4" style="border-radius: 10px;"></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button class="btn btn-primary d-none w-100 py-2" id="btnLoader" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Memproses...
                </button>
                <div class="d-flex w-100 gap-2" id="modalButtons">
                    <button onclick="checkForm()" id="btnSimpan" class="btn btn-primary flex-grow-1 py-2 box-primary-shadow fw-bold">Simpan Data</button>
                    <button class="btn btn-light px-4" onclick="reset()" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('formTambahJS')
<script>
    // Fungsi agar input hanya angka
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function checkForm() {
        const kode = $("input[name='kode']").val();
        const jenis = $("input[name='jenisbarang']").val();
        setLoading(true);
        resetValid();

        if (kode == "") {
            validasi('Kode Initial wajib di isi!', 'warning');
            $("input[name='kode']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (jenis == "") {
            validasi('Jenis Barang wajib di isi!', 'warning');
            $("input[name='jenisbarang']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else {
            submitForm();
        }
    }

    function submitForm() {
        const kode = $("input[name='kode']").val();
        const jenis = $("input[name='jenisbarang']").val();
        const ket = $("textarea[name='ket']").val();

        $.ajax({
            type: 'POST',
            url: "{{route('jenisbarang.store')}}",
            enctype: 'multipart/form-data',
            data: {
                kode: kode, // Kirim kode ke controller
                jenisbarang: jenis,
                ket: ket
            },
            success: function(data) {
                $('#modaldemo8').modal('toggle');
                swal({
                    title: "Berhasil ditambah!",
                    type: "success"
                });
                table.ajax.reload(null, false);
                reset();
            }
        });
    }

    function resetValid() {
        $("input[name='kode']").removeClass('is-invalid');
        $("input[name='jenisbarang']").removeClass('is-invalid');
        $("textarea[name='ket']").removeClass('is-invalid');
    };

    function reset() {
        resetValid();
        $("input[name='kode']").val('');
        $("input[name='jenisbarang']").val('');
        $("textarea[name='ket']").val('');
        setLoading(false);
    }

    function setLoading(bool) {
        if (bool == true) {
            $('#btnLoader').removeClass('d-none');
            $('#btnSimpan').addClass('d-none');
        } else {
            $('#btnSimpan').removeClass('d-none');
            $('#btnLoader').addClass('d-none');
        }
    }
</script>
@endsection