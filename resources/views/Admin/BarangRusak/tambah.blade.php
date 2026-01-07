<div class="modal fade" data-bs-backdrop="static" id="modaldemo8">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Barang Rusak</h6>
                <button onclick="reset()" aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="brkode" class="form-label">Kode Barang Rusak <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="brkode" readonly class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="tglrusak" class="form-label">Tanggal Rusak <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="tglrusak" class="form-control datepicker-date"
                                value="{{ date('Y-m-d') }}" readonly style="background-color: #fff; cursor: pointer;"
                                placeholder="Pilih Tanggal">
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
                            <label for="jml" class="form-label">Jumlah Rusak <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="jml" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="keterangan" class="form-label">Keterangan / Penyebab</label>
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
            const tgl = $("input[name='tglrusak']").val();
            const barang = $("input[name='kdbarang']").val();
            const jml = $("input[name='jml']").val();

            setLoading(true);
            resetValid();

            if (tgl == "") {
                validasi('Tanggal Rusak wajib diisi!', 'warning');
                $("input[name='tglrusak']").addClass('is-invalid');
                setLoading(false);
                return false;
            } else if (barang == "") {
                validasi('Barang wajib dipilih!', 'warning');
                $("input[name='nmbarang']").addClass('is-invalid');
                setLoading(false);
                return false;
            } else if (jml == "" || jml == "0") {
                validasi('Jumlah Rusak wajib diisi!', 'warning');
                $("input[name='jml']").addClass('is-invalid');
                setLoading(false);
                return false;
            } else {
                submitForm();
            }
        }

        function submitForm() {
            const brkode = $("input[name='brkode']").val();
            const tgl = $("input[name='tglrusak']").val();
            const barang = $("input[name='kdbarang']").val();
            const jml = $("input[name='jml']").val();
            const keterangan = $("textarea[name='keterangan']").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('barang-rusak.store') }}",
                enctype: 'multipart/form-data',
                data: {
                    brkode: brkode,
                    tglrusak: tgl,
                    barang: barang,
                    jml: jml,
                    keterangan: keterangan,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.error) {
                        swal({
                            title: "Gagal",
                            text: data.error,
                            type: "warning"
                        });
                    } else {
                        $('#modaldemo8').modal('toggle');
                        swal({
                            title: "Berhasil",
                            text: "Data berhasil disimpan!",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#table-1').DataTable().ajax.reload();
                        reset();
                    }
                    setLoading(false);
                },
                error: function(data) {
                    swal({
                        title: "Gagal",
                        text: "Terjadi kesalahan sistem",
                        type: "error"
                    });
                    setLoading(false);
                }
            });
        }

        function resetValid() {
            $("input[name='tglrusak']").removeClass('is-invalid');
            $("input[name='nmbarang']").removeClass('is-invalid');
            $("input[name='jml']").removeClass('is-invalid');
        };

        function reset() {
            resetValid();
            // 1. Reset Field
            $("input[name='brkode']").val('');
            $("input[name='kdbarang']").val('');
            $("input[name='nmbarang']").val('');
            $("input[name='jml']").val('0');
            $("textarea[name='keterangan']").val('');
            $("#satuan").val('');
            $("#jenis").val('');

            // 2. Reset Tanggal ke Hari Ini
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear() + "-" + (month) + "-" + (day);

            $('input[name="tglrusak"]').val(today);
            try {
                $('.datepicker-date').datepicker('update', today);
            } catch (e) {}

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

        function validasi(judul, status) {
            swal({
                title: judul,
                type: status,
                timer: 2000,
                showConfirmButton: false
            });
        }
    </script>
@endsection