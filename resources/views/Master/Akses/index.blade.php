@extends('Master.Layouts.app', ['title' => $title])
<?php

use App\Models\Admin\AksesModel;
use App\Models\Admin\SubmenuModel; ?>

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Akses</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Settings</li>
            <li class="breadcrumb-item active" aria-current="page">Akses</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom-0 pb-0">
                <h3 class="card-title fw-bold fs-18">Manajemen Hak Akses</h3>
                <p class="text-muted fs-12 mb-0">Konfigurasi izin akses modul untuk setiap peran pengguna di sistem.</p>
            </div>
            <div class="card-body pt-4">

                <div class="bg-light p-4 rounded-3 mb-4 section-filter">
                    <div class="row align-items-end g-3">
                        <div class="col-md-5">
                            <div class="form-group mb-0">
                                <label class="fs-12 fw-bold text-muted mb-1">Pilih Peran Pengguna (Role)</label>
                                <div class="d-flex">
                                    <select name="role" class="form-control select2">
                                        <option value="">-- Pilih Role --</option>
                                        @foreach($role as $r)
                                        <option value="{{$r->role_id}}" {{$roleid == $r->role_id ? 'selected' : ''}}>{{$r->role_title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="ms-1">
                                        <button type="submit" onclick="submitRole()" class="btn btn-primary px-4">Pilih</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @if($detailrole != '')
                        <div class="col-md-7 d-flex justify-content-end gap-2">
                            @if(Session::get('user')->role_slug != $detailrole->role_slug)
                            <button class="btn btn-outline-secondary border px-3" onclick="unsetAll({{$detailrole->role_id}})">
                                <i class="fe fe-shield-off me-2"></i>Non-aktifkan Semua
                            </button>
                            @else
                            <button disabled class="btn btn-outline-secondary border px-3" title="Tidak dapat menonaktifkan role sendiri">
                                <i class="fe fe-shield-off me-2"></i>Non-aktifkan Semua
                            </button>
                            @endif
                            <button class="btn btn-success px-4" onclick="setAll({{$detailrole->role_id}})">
                                <i class="fe fe-shield me-2"></i>Aktifkan Semua
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                @if($detailrole != '')
                <div class="d-flex align-items-center mb-3 mt-4">
                    <div class="bg-primary-transparent p-2 rounded me-3">
                        <i class="fe fe-key fs-20 text-primary"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">Hak Akses Menu Utama</h4>
                        <p class="text-muted fs-12 mb-0">Role: <span class="badge bg-primary-transparent text-primary fw-bold">{{$detailrole->role_title}}</span></p>
                    </div>
                </div>
                
                <div class="table-responsive mb-5">
                    <table class="table table-hover border-bottom mb-0">
                        <thead class="bg-light-50">
                            <tr>
                                <th class="text-muted fw-bold">NAMA MENU</th>
                                <th class="text-muted fw-bold text-center" width="10%">VIEW</th>
                                <th class="text-muted fw-bold text-center" width="10%">CREATE</th>
                                <th class="text-muted fw-bold text-center" width="10%">UPDATE</th>
                                <th class="text-muted fw-bold text-center" width="10%">DELETE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menu as $m)
                            <tr>
                                <td>
                                    <span class="fw-bold">
                                        {{$m->menu_judul}}
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $getView = AksesModel::where(array('menu_id' => $m->menu_id, 'role_id' => $roleid, 'akses_type' => 'view'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5" onclick="">
                                        @if($getView == '')
                                        <input type="checkbox" onchange="addAkses('{{$m->menu_id}}', '{{$roleid}}', 'menu', 'view')" name="viewMenu[]" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('{{$m->menu_id}}', '{{$roleid}}', 'menu', 'view')" checked name="viewMenu[]" class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                </td>
                                <td>
                                    @if($getView != '')
                                    <?php
                                    $getCreate = AksesModel::where(array('menu_id' => $m->menu_id, 'role_id' => $roleid, 'akses_type' => 'create'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getCreate == '')
                                        <input type="checkbox" onchange="addAkses('{{$m->menu_id}}', '{{$roleid}}', 'menu', 'create')" name="createMenu[]" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('{{$m->menu_id}}', '{{$roleid}}', 'menu', 'create')" checked name="createMenu[]" class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView != '')
                                    <?php
                                    $getUpdate = AksesModel::where(array('menu_id' => $m->menu_id, 'role_id' => $roleid, 'akses_type' => 'update'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getUpdate == '')
                                        <input type="checkbox" onchange="addAkses('{{$m->menu_id}}', '{{$roleid}}', 'menu', 'update')" name="updateMenu[]" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('{{$m->menu_id}}', '{{$roleid}}', 'menu', 'update')" checked name="updateMenu[]" class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView != '')
                                    <?php
                                    $getDelete = AksesModel::where(array('menu_id' => $m->menu_id, 'role_id' => $roleid, 'akses_type' => 'delete'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getDelete == '')
                                        <input type="checkbox" onchange="addAkses('{{$m->menu_id}}', '{{$roleid}}', 'menu', 'delete')" name="deleteMenu[]" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('{{$m->menu_id}}', '{{$roleid}}', 'menu', 'delete')" checked name="deleteMenu[]" class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($menusub) > 0)
                <div class="d-flex align-items-center mb-3 mt-5">
                    <div class="bg-success-transparent p-2 rounded me-3">
                        <i class="fe fe-layers fs-20 text-success"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">Hak Akses Sub Menu</h4>
                        <p class="text-muted fs-12 mb-0">Modul dengan struktur bertingkat.</p>
                    </div>
                </div>
                @endif
                @foreach($menusub as $ms)
                <div class="d-flex align-items-center justify-content-between mt-4 mb-2 bg-light-50 p-3 rounded-top border">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fe fe-folder me-2"></i>{{$ms->menu_judul}}</h6>
                    <?php
                    $getView1 = AksesModel::where(array('menu_id' => $ms->menu_id, 'role_id' => $roleid, 'akses_type' => 'view'))->first();
                    ?>
                    <label class="custom-switch form-switch mb-3">
                        @if($getView1 == '')
                        <input type="checkbox" onchange="addAkses('{{$ms->menu_id}}', '{{$roleid}}', 'menu', 'view')" class="custom-switch-input">
                        @else
                        <input type="checkbox" onchange="removeAkses('{{$ms->menu_id}}', '{{$roleid}}', 'menu', 'view')" checked class="custom-switch-input">
                        @endif
                        <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                    </label>
                </div>
                <div class="table-responsive mb-4">
                    <table class="table table-hover border mb-0">
                        <thead class="bg-light-50">
                            <tr>
                                <th class="text-muted fw-bold">SUB MENU</th>
                                <th class="text-muted fw-bold text-center" width="10%">VIEW</th>
                                <th class="text-muted fw-bold text-center" width="10%">CREATE</th>
                                <th class="text-muted fw-bold text-center" width="10%">UPDATE</th>
                                <th class="text-muted fw-bold text-center" width="10%">DELETE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $submenu = SubmenuModel::where('menu_id', '=', $ms->menu_id)->orderBy('submenu_sort', 'ASC')->get();
                            ?>
                            @foreach($submenu as $sm)
                            <tr>
                                <td>
                                    <span class="fw-bold">
                                        {{$sm->submenu_judul}}
                                    </span>
                                </td>
                                <td>
                                    @if($getView1 != '')
                                    <?php
                                    $getView11 = AksesModel::where(array('submenu_id' => $sm->submenu_id, 'role_id' => $roleid, 'akses_type' => 'view'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getView11 == '')
                                        <input type="checkbox" onchange="addAkses('{{$sm->submenu_id}}', '{{$roleid}}', 'submenu', 'view')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('{{$sm->submenu_id}}', '{{$roleid}}', 'submenu', 'view')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses {{$ms->menu_judul}}">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView1 != '')
                                    @if($getView11 != '')
                                    <?php
                                    $getCreate1 = AksesModel::where(array('submenu_id' => $sm->submenu_id, 'role_id' => $roleid, 'akses_type' => 'create'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getCreate1 == '')
                                        <input type="checkbox" onchange="addAkses('{{$sm->submenu_id}}', '{{$roleid}}', 'submenu', 'create')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('{{$sm->submenu_id}}', '{{$roleid}}', 'submenu', 'create')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses {{$ms->menu_judul}}">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView1 != '')
                                    @if($getView11 != '')
                                    <?php
                                    $getUpdate1 = AksesModel::where(array('submenu_id' => $sm->submenu_id, 'role_id' => $roleid, 'akses_type' => 'update'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getUpdate1 == '')
                                        <input type="checkbox" onchange="addAkses('{{$sm->submenu_id}}', '{{$roleid}}', 'submenu', 'update')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('{{$sm->submenu_id}}', '{{$roleid}}', 'submenu', 'update')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses {{$ms->menu_judul}}">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView1 != '')
                                    @if($getView11 != '')
                                    <?php
                                    $getDelete1 = AksesModel::where(array('submenu_id' => $sm->submenu_id, 'role_id' => $roleid, 'akses_type' => 'delete'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getDelete1 == '')
                                        <input type="checkbox" onchange="addAkses('{{$sm->submenu_id}}', '{{$roleid}}', 'submenu', 'delete')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('{{$sm->submenu_id}}', '{{$roleid}}', 'submenu', 'delete')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses {{$ms->menu_judul}}">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                @endforeach

                <div class="d-flex align-items-center mb-3 mt-5">
                    <div class="bg-warning-transparent p-2 rounded me-3">
                        <i class="fe fe-settings fs-20 text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-0">Hak Akses Pengaturan</h4>
                        <p class="text-muted fs-12 mb-0">Akses modul konfigurasi sistem.</p>
                    </div>
                    <?php
                    $getView2 = AksesModel::where(array('othermenu_id' => 1, 'role_id' => $detailrole->role_id, 'akses_type' => 'view'))->first();
                    ?>
                    @if(Session::get('user')->role_slug != $detailrole->role_slug)
                    <label class="custom-switch form-switch mb-3">
                        @if($getView2 == '')
                        <input type="checkbox" onchange="addAkses('1', '{{$detailrole->role_id}}', 'othermenu', 'view')" class="custom-switch-input">
                        @else
                        <input type="checkbox" onchange="removeAkses('1', '{{$detailrole->role_id}}', 'othermenu', 'view')" checked class="custom-switch-input">
                        @endif
                        <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                    </label>
                    @endif
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-hover border mb-0">
                        <thead class="bg-light-50">
                            <tr>
                                <th class="text-muted fw-bold">MODUL PENGATURAN</th>
                                <th class="text-muted fw-bold text-center" width="10%">VIEW</th>
                                <th class="text-muted fw-bold text-center" width="10%">CREATE</th>
                                <th class="text-muted fw-bold text-center" width="10%">UPDATE</th>
                                <th class="text-muted fw-bold text-center" width="10%">DELETE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="fw-bold">
                                        Menu
                                    </span>
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    <?php
                                    $getView21 = AksesModel::where(array('othermenu_id' => 2, 'role_id' => $roleid, 'akses_type' => 'view'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getView21 == '')
                                        <input type="checkbox" onchange="addAkses('2', '{{$roleid}}', 'othermenu', 'view')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('2', '{{$roleid}}', 'othermenu', 'view')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView21 != '')
                                    <?php
                                    $getCreate2 = AksesModel::where(array('othermenu_id' => 2, 'role_id' => $roleid, 'akses_type' => 'create'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getCreate2 == '')
                                        <input type="checkbox" onchange="addAkses('2', '{{$roleid}}', 'othermenu', 'create')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('2', '{{$roleid}}', 'othermenu', 'create')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView21 != '')
                                    <?php
                                    $getUpdate2 = AksesModel::where(array('othermenu_id' => 2, 'role_id' => $roleid, 'akses_type' => 'update'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getUpdate2 == '')
                                        <input type="checkbox" onchange="addAkses('2', '{{$roleid}}', 'othermenu', 'update')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('2', '{{$roleid}}', 'othermenu', 'update')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView21 != '')
                                    <?php
                                    $getDelete2 = AksesModel::where(array('othermenu_id' => 2, 'role_id' => $roleid, 'akses_type' => 'delete'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getDelete2 == '')
                                        <input type="checkbox" onchange="addAkses('2', '{{$roleid}}', 'othermenu', 'delete')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('2', '{{$roleid}}', 'othermenu', 'delete')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold">
                                        Role
                                    </span>
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    <?php
                                    $getView3 = AksesModel::where(array('othermenu_id' => 3, 'role_id' => $roleid, 'akses_type' => 'view'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getView3 == '')
                                        <input type="checkbox" onchange="addAkses('3', '{{$roleid}}', 'othermenu', 'view')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('3', '{{$roleid}}', 'othermenu', 'view')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView3 != '')
                                    <?php
                                    $getCreate3 = AksesModel::where(array('othermenu_id' => 3, 'role_id' => $roleid, 'akses_type' => 'create'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getCreate3 == '')
                                        <input type="checkbox" onchange="addAkses('3', '{{$roleid}}', 'othermenu', 'create')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('3', '{{$roleid}}', 'othermenu', 'create')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView3 != '')
                                    <?php
                                    $getUpdate3 = AksesModel::where(array('othermenu_id' => 3, 'role_id' => $roleid, 'akses_type' => 'update'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getUpdate3 == '')
                                        <input type="checkbox" onchange="addAkses('3', '{{$roleid}}', 'othermenu', 'update')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('3', '{{$roleid}}', 'othermenu', 'update')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView3 != '')
                                    <?php
                                    $getDelete3 = AksesModel::where(array('othermenu_id' => 3, 'role_id' => $roleid, 'akses_type' => 'delete'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getDelete3 == '')
                                        <input type="checkbox" onchange="addAkses('3', '{{$roleid}}', 'othermenu', 'delete')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('3', '{{$roleid}}', 'othermenu', 'delete')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold">
                                        User
                                    </span>
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    <?php
                                    $getView4 = AksesModel::where(array('othermenu_id' => 4, 'role_id' => $roleid, 'akses_type' => 'view'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getView4 == '')
                                        <input type="checkbox" onchange="addAkses('4', '{{$roleid}}', 'othermenu', 'view')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('4', '{{$roleid}}', 'othermenu', 'view')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView4 != '')
                                    <?php
                                    $getCreate4 = AksesModel::where(array('othermenu_id' => 4, 'role_id' => $roleid, 'akses_type' => 'create'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getCreate4 == '')
                                        <input type="checkbox" onchange="addAkses('4', '{{$roleid}}', 'othermenu', 'create')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('4', '{{$roleid}}', 'othermenu', 'create')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView4 != '')
                                    <?php
                                    $getUpdate4 = AksesModel::where(array('othermenu_id' => 4, 'role_id' => $roleid, 'akses_type' => 'update'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getUpdate4 == '')
                                        <input type="checkbox" onchange="addAkses('4', '{{$roleid}}', 'othermenu', 'update')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('4', '{{$roleid}}', 'othermenu', 'update')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView4 != '')
                                    <?php
                                    $getDelete4 = AksesModel::where(array('othermenu_id' => 4, 'role_id' => $roleid, 'akses_type' => 'delete'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getDelete4 == '')
                                        <input type="checkbox" onchange="addAkses('4', '{{$roleid}}', 'othermenu', 'delete')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('4', '{{$roleid}}', 'othermenu', 'delete')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                            </tr>
                            @if(Session::get('user')->role_slug != $detailrole->role_slug)
                            <tr>
                                <td>
                                    <span class="fw-bold">
                                        Akses
                                    </span>
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    <?php
                                    $getView5 = AksesModel::where(array('othermenu_id' => 5, 'role_id' => $detailrole->role_id, 'akses_type' => 'view'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getView5 == '')
                                        <input type="checkbox" onchange="addAkses('5', '{{$detailrole->role_id}}', 'othermenu', 'view')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('5', '{{$detailrole->role_id}}', 'othermenu', 'view')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView5 != '')
                                    <?php
                                    $getCreate5 = AksesModel::where(array('othermenu_id' => 5, 'role_id' => $detailrole->role_id, 'akses_type' => 'create'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getCreate5 == '')
                                        <input type="checkbox" onchange="addAkses('5', '{{$detailrole->role_id}}', 'othermenu', 'create')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('5', '{{$detailrole->role_id}}', 'othermenu', 'create')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView5 != '')
                                    <?php
                                    $getUpdate5 = AksesModel::where(array('othermenu_id' => 5, 'role_id' => $detailrole->role_id, 'akses_type' => 'update'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getUpdate5 == '')
                                        <input type="checkbox" onchange="addAkses('5', '{{$detailrole->role_id}}', 'othermenu', 'update')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('5', '{{$detailrole->role_id}}', 'othermenu', 'update')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView5 != '')
                                    <?php
                                    $getDelete5 = AksesModel::where(array('othermenu_id' => 5, 'role_id' => $detailrole->role_id, 'akses_type' => 'delete'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getDelete5 == '')
                                        <input type="checkbox" onchange="addAkses('5', '{{$detailrole->role_id}}', 'othermenu', 'delete')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('5', '{{$detailrole->role_id}}', 'othermenu', 'delete')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                            </tr>
                            @endif

                            <tr>
                                <td>
                                    <span class="fw-bold">
                                        Web
                                    </span>
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    <?php
                                    $getView6 = AksesModel::where(array('othermenu_id' => 6, 'role_id' => $detailrole->role_id, 'akses_type' => 'view'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getView6 == '')
                                        <input type="checkbox" onchange="addAkses('6', '{{$detailrole->role_id}}', 'othermenu', 'view')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('6', '{{$detailrole->role_id}}', 'othermenu', 'view')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView6 != '')
                                    <?php
                                    $getCreate6 = AksesModel::where(array('othermenu_id' => 6, 'role_id' => $detailrole->role_id, 'akses_type' => 'create'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getCreate6 == '')
                                        <input type="checkbox" onchange="addAkses('6', '{{$detailrole->role_id}}', 'othermenu', 'create')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('6', '{{$detailrole->role_id}}', 'othermenu', 'create')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView6 != '')
                                    <?php
                                    $getUpdate6 = AksesModel::where(array('othermenu_id' => 6, 'role_id' => $detailrole->role_id, 'akses_type' => 'update'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getUpdate6 == '')
                                        <input type="checkbox" onchange="addAkses('6', '{{$detailrole->role_id}}', 'othermenu', 'update')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('6', '{{$detailrole->role_id}}', 'othermenu', 'update')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>
                                    @if($getView2 != '')
                                    @if($getView6 != '')
                                    <?php
                                    $getDelete6 = AksesModel::where(array('othermenu_id' => 6, 'role_id' => $detailrole->role_id, 'akses_type' => 'delete'))->first();
                                    ?>
                                    <label class="custom-switch form-switch me-5">
                                        @if($getDelete6 == '')
                                        <input type="checkbox" onchange="addAkses('6', '{{$detailrole->role_id}}', 'othermenu', 'delete')" class="custom-switch-input">
                                        @else
                                        <input type="checkbox" onchange="removeAkses('6', '{{$detailrole->role_id}}', 'othermenu', 'delete')" checked class="custom-switch-input">
                                        @endif
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses view">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                    @else
                                    <label class="custom-switch form-switch me-5" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Aktifkan akses Settings">
                                        <input type="checkbox" disabled name="custom-switch-checkbox1" class="custom-switch-input">
                                        <span class="custom-switch-indicator custom-switch-indicator-sm"></span>
                                    </label>
                                    @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                @endif

            </div>

        </div>
    </div>
</div>
<!-- END ROW -->

@endsection

@section('scripts')
<script>
    function submitRole() {
        role = $('select[name="role"]').val();
        if (role != '') {
            window.location.href = "{{ url('/admin/akses') }}/" + parseInt(role);
        } else {
            window.location.href = "{{ url('/admin/akses') }}/" + "role";
        }
    }

    function addAkses(idmenu, idrole, type, akses) {
        window.location.href = "{{ url('/admin/akses/addAkses') }}/" + idmenu + '/' + parseInt(idrole) + "/" + type + "/" + akses;
    }

    function removeAkses(idmenu, idrole, type, akses) {
        window.location.href = "{{ url('/admin/akses/removeAkses') }}/" + idmenu + '/' + parseInt(idrole) + "/" + type + "/" + akses;
    }

    function setAll(idrole) {
        window.location.href = "{{ url('/admin/akses/setAll') }}/" + parseInt(idrole);
    }

    function unsetAll(idrole) {
        window.location.href = "{{ url('/admin/akses/unsetAll') }}/" + parseInt(idrole);
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