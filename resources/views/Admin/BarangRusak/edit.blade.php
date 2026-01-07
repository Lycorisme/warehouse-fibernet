<div class="modal fade" data-bs-backdrop="static" id="Umodaldemo8">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Ubah Barang Rusak</h6>
                <button aria-label="Close" onclick="resetU()" class="btn-close" data-bs-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="idbrU">
                        <div class="form-group">
                            <label for="brkodeU" class="form-label">Kode Barang Rusak <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="brkodeU" readonly class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="tglrusakU" class="form-label">Tanggal Rusak <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="tglrusakU" class="form-control datepicker-date" readonly
                                style="background-color: #fff; cursor: pointer;" placeholder="Pilih Tanggal">
                        </div>
                        <div class="form-group">
                            <label for="barangU" class="form-label">Barang <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="hidden" name="kdbarangU">
                                <input type="text" name="nmbarangU" id="nmbarangU" readonly class="form-control"
                                    placeholder="Cari Barang">
                                <button class="btn btn-primary-light" onclick="modalBarangU()" type="button"><i
                                        class="fe fe-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" readonly class="form-control" id="satuanU">
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <input type="text" readonly class="form-control" id="jenisU">
                        </div>
                        <div class="form-group">
                            <label for="jmlU" class="form-label">Jumlah Rusak <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="jmlU" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="keteranganU" class="form-label">Keterangan / Penyebab</label>
                            <textarea name="keteranganU" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success d-none" id="btnLoaderU" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkFormU()" id="btnSimpanU" class="btn btn-success">Simpan
                    Perubahan</a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="resetU()" data-bs-dismiss="modal">Batal</a>
            </div>
        </div>
    </div>
</div>

@section('formEditJS')
    <script>
        function modalBarangU() {
            $('#modalBarang').modal('show');
            $('#randkey').val('update');
        }

        function update(data) {
            $("input[name='idbrU']").val(data.br_id);
            $("input[name='brkodeU']").val(data.br_kode);
            $("input[name='tglrusakU']").val(data.br_tanggal);
            $("input[name='kdbarangU']").val(data.barang_kode);
            $("input[name='nmbarangU']").val(data.barang_nama);
            $("input[name='jmlU']").val(data.br_jumlah);
            // Perhatikan: Controller mengirim 'br_keterangan', view pakai 'keteranganU'
            $("textarea[name='keteranganU']").val(data.br_keterangan);
            
            // Satuan/Jenis kosongkan dulu (atau fetch ajax jika perlu)
            $("#satuanU").val('');
            $("#jenisU").val('');
            
            $('#Umodaldemo8').modal('show');
        }

        function checkFormU() {
            const tgl = $("input[name='tglrusakU']").val();
            const barang = $("input[name='kdbarangU']").val();
            const jml = $("input[name='jmlU']").val();

            setLoadingU(true);
            resetValidU();

            if (tgl == "" || barang == "" || jml == "" || jml == "0") {
                swal({ title: "Gagal", text: "Lengkapi Data!", type: "warning" });
                setLoadingU(false);
                return false;
            } else {
                submitFormU();
            }
        }

        function submitFormU() {
            const id = $("input[name='idbrU']").val();
            // Ambil semua value input
            const brkode = $("input[name='brkodeU']").val();
            const tgl = $("input[name='tglrusakU']").val();
            const barang = $("input[name='kdbarangU']").val();
            const jml = $("input[name='jmlU']").val();
            const keterangan = $("textarea[name='keteranganU']").val();

            $.ajax({
                type: 'POST',
                url: "{{ url('admin/barang-rusak/proses_ubah') }}/" + id,
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
                    if (data.success) {
                        swal({ title: "Berhasil", text: "Data berhasil diubah!", type: "success", timer: 1500, showConfirmButton: false });
                        $('#Umodaldemo8').modal('toggle');
                        $('#table-1').DataTable().ajax.reload(null, false);
                        resetU();
                    } else {
                        swal({ title: "Gagal", text: "Gagal Mengubah Data", type: "error" });
                    }
                    setLoadingU(false);
                },
                error: function(data) {
                    swal({ title: "Gagal", text: "Terjadi kesalahan sistem", type: "error" });
                    setLoadingU(false);
                }
            });
        }

        function resetValidU() {
            $("input[name='tglrusakU']").removeClass('is-invalid');
            $("input[name='jmlU']").removeClass('is-invalid');
        };

        function resetU() {
            resetValidU();
            $("input[name='idbrU']").val('');
            $("input[name='brkodeU']").val('');
            $("input[name='tglrusakU']").val('');
            $("input[name='kdbarangU']").val('');
            $("input[name='nmbarangU']").val('');
            $("input[name='jmlU']").val('0');
            $("textarea[name='keteranganU']").val('');
            $("#satuanU").val('');
            $("#jenisU").val('');
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