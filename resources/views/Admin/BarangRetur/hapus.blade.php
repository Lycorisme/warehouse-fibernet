<div class="modal fade" data-bs-backdrop="static" id="Hmodaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body text-center p-4 pb-5">
                <button type="reset" aria-label="Close" onclick="resetH()" class="btn-close position-absolute"
                    data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                <br>
                <i class="icon icon-exclamation fs-70 text-warning lh-1 my-5 d-inline-block"></i>
                <h3 class="mb-5">Yakin hapus <span id="vretur"></span> ?</h3>
                <input type="hidden" name="idretur" id="idretur">
                <button class="btn btn-danger-light pd-x-25 d-none" id="btnLoaderH" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button onclick="submitFormH()" class="btn btn-danger-light pd-x-25" id="btnSubmit">Iya</button>
                <button type="reset" data-bs-dismiss="modal" class="btn btn-default pd-x-25">Batal</button>
            </div>
        </div>
    </div>
</div>

@section('formHapusJS')
    <script>
        function hapus(data) {
            $("input[name='idretur']").val(data.retur_id);
            $("#vretur").html(data.retur_kode);
            $('#Hmodaldemo8').modal('show');
        }

        function submitFormH() {
            setLoadingH(true);
            const id = $("input[name='idretur']").val();
            
            $.ajax({
                type: 'POST',
                // Pastikan route name 'barang-retur.proses_hapus' ada di web.php
                url: "{{ url('admin/barang-retur/proses_hapus') }}/" + id,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    swal({
                        title: "Berhasil dihapus!",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#Hmodaldemo8').modal('toggle');
                    $('#table-1').DataTable().ajax.reload(null, false);
                    resetH();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    swal({
                        title: "Gagal",
                        text: "Gagal menghapus! Error: " + xhr.status,
                        type: "error"
                    });
                    setLoadingH(false);
                }
            });
        }

        function resetH() {
            $("input[name='idretur']").val('');
            setLoadingH(false);
        }

        function setLoadingH(bool) {
            if (bool == true) {
                $('#btnLoaderH').removeClass('d-none');
                $('#btnSubmit').addClass('d-none');
            } else {
                $('#btnSubmit').removeClass('d-none');
                $('#btnLoaderH').addClass('d-none');
            }
        }
    </script>
@endsection