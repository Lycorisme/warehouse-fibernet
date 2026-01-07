@extends('Master.Layouts.app', ['title' => $title])

<?php

use App\Models\Admin\SubmenuModel;
?>

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Menu</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Settings</li>
            <li class="breadcrumb-item active" aria-current="page">Menu</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- Row -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom-0 pb-0 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                <div>
                    <h3 class="card-title fw-bold fs-18">Manajemen Menu</h3>
                    <p class="text-muted fs-12 mb-0">Kelola struktur navigasi utama dan sub-menu aplikasi.</p>
                </div>
                <div>
                    <a class="modal-effect btn btn-primary box-primary-shadow px-4 py-2" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">
                        <i class="fe fe-plus-circle me-2"></i> Tambah Menu
                    </a>
                </div>
            </div>
            <div class="card-body pt-4">
                <div class="table-responsive">
                    <table class="table table-hover border-bottom mb-0">
                        <thead class="bg-light-50">
                            <tr>
                                <th class="border-bottom-0 text-muted fw-bold" width="15%">URUTAN</th>
                                <th class="border-bottom-0 text-muted fw-bold" width="5%">ICON</th>
                                <th class="border-bottom-0 text-muted fw-bold">JUDUL MENU</th>
                                <th class="border-bottom-0 text-muted fw-bold">TIPE</th>
                                <th class="border-bottom-0 text-muted fw-bold">REDIRECT URL</th>
                                <th class="border-bottom-0 text-muted fw-bold text-end" width="1%">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-bold fs-14 text-dark">{{$d->menu_sort}}</span>
                                        <div class="btn-group shadow-none">
                                            <button type="button" onclick="sortup('{{$d->menu_sort}}')" class="btn btn-sm btn-icon btn-outline-light border text-success" {{$d->menu_sort == 1 ? "disabled" : ""}} title="Pindah Atas"><i class="fe fe-arrow-up"></i></button>
                                            <button type="button" onclick="sortdown('{{$d->menu_sort}}')" class="btn btn-sm btn-icon btn-outline-light border text-danger" {{$d->menu_sort == count($data) ? "disabled" : ""}} title="Pindah Bawah"><i class="fe fe-arrow-down"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center"><i class="fe fe-{{$d->menu_icon}} fs-18 text-primary bg-primary-transparent p-2 rounded-circle"></i></td>
                                <td class="align-middle fw-semibold text-dark">{{$d->menu_judul}}</td>
                                <td class="align-middle">
                                    @if($d->menu_type == 1)
                                    <span class="badge bg-primary-transparent text-primary border-primary-50 px-3">Menu Tunggal</span>
                                    @elseif($d->menu_type == 2)
                                    <span class="badge bg-success-transparent text-success border-success-50 px-3">Menu Group</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($d->menu_type == 1)
                                    <code class="text-primary fw-medium">{{$d->menu_redirect}}</code>
                                    @elseif($d->menu_type == 2)
                                    <?php
                                    $submenu = SubmenuModel::where('menu_id', '=', $d->menu_id)->orderBy('submenu_sort', 'ASC')->get();
                                    ?>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($submenu as $sub)
                                        <span class="badge bg-light text-muted border px-2 fs-11" title="{{$sub->submenu_redirect}}">
                                            <i class="fe fe-corner-down-right me-1"></i>{{$sub->submenu_judul}}
                                        </span>
                                        @endforeach
                                    </div>
                                    @endif
                                </td>
                                <td class="align-middle text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if($d->menu_type == 1)
                                        <button class="btn btn-sm btn-outline-primary border" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Umodaldemo8" onclick="update({{$d}})" title="Edit">
                                            <i class="fe fe-edit-3"></i>
                                        </button>
                                        @elseif($d->menu_type == 2)
                                        <button class="btn btn-sm btn-outline-primary border" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Umodaldemo8" onclick="updatewithsub({{$d}},{{$submenu}})" title="Edit">
                                            <i class="fe fe-edit-3"></i>
                                        </button>
                                        @endif
                                        <button class="btn btn-sm btn-outline-danger border" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Hmodaldemo8" onclick="hapus({{$d}})" title="Hapus">
                                            <i class="fe fe-trash-2"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

@include('Master.Menu.tambah')
@include('Master.Menu.ubah')
@include('Master.Menu.hapus')

<script>
    function sortup(sort) {
        window.location.href = "{{ url('/admin/menu/sortup') }}/" + sort;
    }

    function sortdown(sort) {
        window.location.href = "{{ url('/admin/menu/sortdown') }}/" + sort;
    }
</script>

<script>
    function update(data) {
        $("#myFormU").attr("action", "{{url('/admin/menu')}}/" + data.menu_id);
        $("input[name='uicon']").val(data.menu_icon);
        $("input[name='ujudul']").val(data.menu_judul);
        $("select[name='utype']").val(data.menu_type);
        $("input[name='uredirect']").val(data.menu_redirect);
        setTypeU();
    }

    function updatewithsub(data,sub) {
        $("#myFormU").attr("action", "{{url('/admin/menu')}}/" + data.menu_id);
        $("input[name='uicon']").val(data.menu_icon);
        $("input[name='ujudul']").val(data.menu_judul);
        $("select[name='utype']").val(data.menu_type);
        $("input[name='uredirect']").val(data.menu_redirect);
        setTypeU();
        setSub(sub);
    }

    function hapus(data) {
        $("input[name='idmenu']").val(data.menu_id);
        $("#vmenu").html("menu " + "<b>" + data.menu_judul + "</b>");
    }

    function validasi(judul, status) {
        swal({
            title: judul,
            type: status,
            confirmButtonText: "Iya."
        });
    }
</script>

@endsection