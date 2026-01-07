<div class="modal fade" data-bs-backdrop="static" id="Umodaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark px-2 pt-3">Ubah Informasi Kategori</h5>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="idjenisbarangU">
                
                <div class="form-group mb-4">
                    <label for="kodeU" class="form-label fw-semibold mb-2">Kode Initial <span class="text-danger">*</span></label>
                    <input type="text" name="kodeU" class="form-control form-control-lg fs-14 border-0 bg-light" placeholder="Cth: 01" maxlength="2" onkeypress="return isNumber(event)" style="border-radius: 10px;">
                </div>

                <div class="form-group mb-4">
                    <label for="jenisbarangU" class="form-label fw-semibold mb-2">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="jenisbarangU" class="form-control form-control-lg fs-14 border-0 bg-light" placeholder="" style="border-radius: 10px;">
                </div>
                <div class="form-group mb-0">
                    <label for="ketU" class="form-label fw-semibold mb-2">Deskripsi Kategori</label>
                    <textarea name="ketU" class="form-control border-0 bg-light" rows="4" style="border-radius: 10px;"></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button class="btn btn-success d-none w-100 py-2" id="btnLoaderU" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Menyimpan Perubahan...
                </button>
                <div class="d-flex w-100 gap-2" id="modalButtonsU">
                    <button onclick="checkFormU()" id="btnSimpanU" class="btn btn-success flex-grow-1 py-2 box-success-shadow fw-bold">Simpan Perubahan</button>
                    <button class="btn btn-light px-4" onclick="resetU()" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('formEditJS')
<script>
    function checkFormU() {
        const kode = $("input[name='kodeU']").val();
        const jenis = $("input[name='jenisbarangU']").val();
        setLoadingU(true);
        resetValidU();

        if (kode == "") {
            validasi('Kode Initial wajib di isi!', 'warning');
            $("input[name='kodeU']").addClass('is-invalid');
            setLoadingU(false);
            return false;
        } else if (jenis == "") {
            validasi('Jenis Barang wajib di isi!', 'warning');
            $("input[name='jenisbarangU']").addClass('is-invalid');
            setLoadingU(false);
            return false;
        } else {
            submitFormU();
        }
    }

    function submitFormU() {
        const id = $("input[name='idjenisbarangU']").val();
        const kode = $("input[name='kodeU']").val();
        const jenis = $("input[name='jenisbarangU']").val();
        const ket = $("textarea[name='ketU']").val();

        $.ajax({
            type: 'POST',
            url: "{{url('admin/jenisbarang/proses_ubah')}}/" + id,
            enctype: 'multipart/form-data',
            data: {
                kode: kode, // Kirim sebagai 'kode' ke controller
                jenisbarang: jenis,
                ket: ket
            },
            success: function(data) {
                swal({
                    title: "Berhasil diubah!",
                    type: "success"
                });
                $('#Umodaldemo8').modal('toggle');
                table.ajax.reload(null, false);
                resetU();
            }
        });
    }

    function resetValidU() {
        $("input[name='kodeU']").removeClass('is-invalid');
        $("input[name='jenisbarangU']").removeClass('is-invalid');
        $("textarea[name='ketU']").removeClass('is-invalid');
    };

    function resetU() {
        resetValidU();
        $("input[name='idjenisbarangU']").val('');
        $("input[name='kodeU']").val('');
        $("input[name='jenisbarangU']").val('');
        $("textarea[name='ketU']").val('');
        setLoadingU(false);
    }

    function setLoadingU(bool) {
        if (bool == true) {
            $('#btnLoaderU').removeClass('d-none');
            $('#btnSimpanU').addClass('d-none');
        } else {
            $('#btnSimpanU').removeClass('d-none');
            $('#btnLoaderU').addClass('d-none');
        }
    }
</script>
@endsection