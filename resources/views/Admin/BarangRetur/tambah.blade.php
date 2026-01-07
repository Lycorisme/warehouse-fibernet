<div class="modal fade" data-bs-backdrop="static" id="modaldemo8">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Barang Retur</h6>
                <button onclick="reset()" aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="returkode" class="form-label">Kode Retur <span class="text-danger">*</span></label>
                            <input type="text" name="returkode" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tglretur" class="form-label">Tanggal Retur <span class="text-danger">*</span></label>
                            <input type="text" name="tglretur" class="form-control datepicker-date"
                                value="{{ date('Y-m-d') }}" readonly style="background-color: #fff; cursor: pointer;">
                        </div>
                        <div class="form-group">
                            <label for="barang" class="form-label">Barang <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="hidden" name="kdbarang">
                                <input type="text" name="nmbarang" id="nmbarang" readonly class="form-control"
                                    placeholder="Cari Barang">
                                <button class="btn btn-primary-light" onclick="modalBarang()" type="button"><i
                                        class="fe fe-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" readonly class="form-control" id="satuan">
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <input type="text" readonly class="form-control" id="jenis">
                        </div>
                        <div class="form-group">
                            <label for="jml" class="form-label">Jumlah Retur <span class="text-danger">*</span></label>
                            <input type="number" name="jml" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="keterangan" class="form-label">Keterangan / Alasan Retur</label>
                            <textarea name="keterangan" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary d-none" id="btnLoader" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkForm()" id="btnSimpan" class="btn btn-primary">Simpan</a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="reset()" data-bs-dismiss="modal">Batal</a>
            </div>
        </div>
    </div>
</div>

@section('formTambahJS')
    <script>
        function modalBarang() {
            $('#modalBarang').modal('show');
            $('#randkey').val('tambah');
        }

        function checkForm() {
            const tgl = $("input[name='tglretur']").val();
            const barang = $("input[name='kdbarang']").val();
            const jml = $("input[name='jml']").val();

            setLoading(true);
            resetValid();

            if (tgl == "" || barang == "" || jml == "" || jml == "0") {
                swal({ title: "Gagal", text: "Lengkapi Data!", type: "warning" });
                setLoading(false);
                return false;
            } else {
                submitForm();
            }
        }

        function submitForm() {
            const returkode = $("input[name='returkode']").val();
            const tgl = $("input[name='tglretur']").val();
            const barang = $("input[name='kdbarang']").val();
            const jml = $("input[name='jml']").val();
            const keterangan = $("textarea[name='keterangan']").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('barang-retur.store') }}",
                enctype: 'multipart/form-data',
                data: {
                    returkode: returkode,
                    tglretur: tgl,
                    barang: barang,
                    jml: jml,
                    keterangan: keterangan,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.success) {
                        $('#modaldemo8').modal('toggle');
                        swal({ title: "Berhasil", text: "Data berhasil disimpan!", type: "success", timer: 1500, showConfirmButton: false });
                        $('#table-1').DataTable().ajax.reload();
                        reset();
                    } else {
                        swal({ title: "Gagal", text: "Gagal menyimpan data", type: "error" });
                    }
                    setLoading(false);
                },
                error: function(data) {
                    swal({ title: "Gagal", text: "Terjadi kesalahan sistem", type: "error" });
                    setLoading(false);
                }
            });
        }

        function resetValid() {
            $("input[name='tglretur']").removeClass('is-invalid');
            $("input[name='nmbarang']").removeClass('is-invalid');
            $("input[name='jml']").removeClass('is-invalid');
        };

        function reset() {
            resetValid();
            $("input[name='returkode']").val('');
            $("input[name='kdbarang']").val('');
            $("input[name='nmbarang']").val('');
            $("input[name='jml']").val('0');
            $("textarea[name='keterangan']").val('');
            $("#satuan").val('');
            $("#jenis").val('');
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