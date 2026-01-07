@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->

    <div class="page-header">
        <h1 class="page-title">{{ $title }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Master Data</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
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
                        <h3 class="card-title fw-bold fs-18">Daftar Barang</h3>
                        <p class="text-muted fs-12 mb-0">Kelola dan lihat seluruh data inventaris barang Anda.</p>
                    </div>
                    @if ($hakTambah > 0)
                        <div class="mt-3 mt-sm-0">
                            <a class="modal-effect btn btn-primary box-primary-shadow px-4 py-2" onclick="generateID()"
                                data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">
                                <i class="fe fe-plus-circle me-2"></i>Tambah Barang</a>
                        </div>
                    @endif
                </div>
                <div class="card-body pt-4">
                    <div class="table-responsive">
                        <table id="table-1" width="100%"
                            class="table table-hover border-bottom dataTable no-footer">
                            <thead class="bg-light-50">
                                <th class="border-bottom-0 text-muted fw-bold" width="1%">NO</th>
                                <th class="border-bottom-0 text-muted fw-bold">GAMBAR</th>
                                <th class="border-bottom-0 text-muted fw-bold">KODE BARANG</th>
                                <th class="border-bottom-0 text-muted fw-bold">NAMA BARANG</th>
                                <th class="border-bottom-0 text-muted fw-bold">JENIS</th>
                                <th class="border-bottom-0 text-muted fw-bold">SATUAN</th>
                                <th class="border-bottom-0 text-muted fw-bold">MERK</th>
                                <th class="border-bottom-0 text-muted fw-bold">STOK</th>
                                <th class="border-bottom-0 text-muted fw-bold">HARGA</th>
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

    @include('Admin.Barang.tambah', ['jenisbarang' => $jenisbarang, 'satuan' => $satuan, 'merk' => $merk])
    @include('Admin.Barang.edit', ['jenisbarang' => $jenisbarang, 'satuan' => $satuan, 'merk' => $merk])
    @include('Admin.Barang.hapus')
    @include('Admin.Barang.gambar')

    <script>
        function generateID() {
            const jenis = $("select[name='jenisbarang']").val();
            const satuan = $("select[name='satuan']").val();
            const merk = $("select[name='merk']").val();

            if (jenis && satuan && merk) {
                $.ajax({
                    url: "{{ route('barang.getkode') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        jenis: jenis,
                        satuan: satuan,
                        merk: merk
                    },
                    success: function(response) {
                        $("input[name='kode']").val(response.kode);
                    }
                });
            } else {
                // Jika admin klik tambah sebelum pilih jenis/merk, beri kode sementara atau kosongkan
                $("input[name='kode']").val("");
            }
        }

        // Tambahkan event listener agar saat Jenis/Satuan/Merk diubah di modal tambah, kode otomatis update
        $(document).on('change', "select[name='jenisbarang'], select[name='satuan'], select[name='merk']", function() {
            // Hanya jalankan jika ini di modal TAMBAH (bukan edit)
            if ($('#modaldemo8').hasClass('show')) {
                generateID();
            }
        });

        function update(data) {
            $("input[name='idbarangU']").val(data.barang_id);
            $("input[name='kodeU']").val(data.barang_kode);
            $("input[name='namaU']").val(data.barang_nama.replace(/_/g, ' '));
            $("select[name='jenisbarangU']").val(data.jenisbarang_id);
            $("select[name='satuanU']").val(data.satuan_id);
            $("select[name='merkU']").val(data.merk_id);
            $("input[name='stokU']").val(data.barang_stok);
            $("input[name='hargaU']").val(data.barang_harga.replace(/_/g, ' '));
            if (data.barang_gambar != 'image.png') {
                $("#outputImgU").attr("src", "{{ asset('storage/barang/') }}" + "/" + data.barang_gambar);
            }
        }

        function hapus(data) {
            $("input[name='idbarang']").val(data.barang_id);
            $("#vbarang").html("barang " + "<b>" + data.barang_nama.replace(/_/g, ' ') + "</b>");
        }

        function gambar(data) {
            if (data.barang_gambar != 'image.png') {
                $("#outputImgG").attr("src", "{{ asset('storage/barang/') }}" + "/" + data.barang_gambar);
            } else {
                $("#outputImgG").attr("src", "{{ url('/assets/default/barang/image.png') }}");
            }
        }

        function validasi(judul, status) {
            swal({
                title: judul,
                type: status,
                confirmButtonText: "Iya"
            });
        }
    </script>
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table;
        $(document).ready(function() {
            //datatables
            table = $('#table-1').DataTable({
                "processing": true,
                "serverSide": true,
                "info": true,
                "order": [],
                "stateSave": true,
                "scrollX": true,
                "lengthMenu": [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                "pageLength": 10,
                lengthChange: true,
                "ajax": {
                    "url": "{{ route('barang.getbarang') }}",
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'img',
                        name: 'barang_gambar',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'barang_kode',
                        name: 'barang_kode',
                    },
                    {
                        data: 'barang_nama',
                        name: 'barang_nama',
                    },
                    {
                        data: 'jenisbarang',
                        name: 'jenisbarang_nama',
                    },
                    {
                        data: 'satuan',
                        name: 'satuan_nama',
                    },
                    {
                        data: 'merk',
                        name: 'merk_nama',
                    },
                    {
                        data: 'totalstok',
                        name: 'barang_stok',
                    },
                    {
                        data: 'currency',
                        name: 'barang_harga'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Tombol Cetak Barcode
                            let btnPrint = `
            <a href="{{ url('admin/barang/cetak-barcode') }}/${row.barang_id}" 
               target="_blank" 
               class="btn btn-sm btn-info-light" 
               title="Cetak Barcode">
                <i class="fe fe-printer"></i>
            </a>`;

                            // Menggabungkan tombol print dengan tombol action dari server (Edit/Hapus)
                            return btnPrint + ' ' + data;
                        }
                    },
                ],
            });
        });
    </script>
@endsection
