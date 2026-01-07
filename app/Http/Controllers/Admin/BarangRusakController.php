<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\BarangRusakModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BarangRusakController extends Controller
{
    public function index()
    {
        $data["title"] = "Barang Rusak";
        $data["hakTambah"] = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')
            ->where(array(
                'tbl_akses.role_id' => Session::get('user')->role_id,
                'tbl_submenu.submenu_judul' => 'Barang Rusak',
                'tbl_akses.akses_type' => 'create'
            ))->count();
            
        return view('Admin.BarangRusak.index', $data);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangRusakModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangrusak.barang_kode')
                ->orderBy('br_id', 'DESC')
                ->get();
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl', function ($row) {
                    $tgl = $row->br_tanggal == '' ? '-' : Carbon::parse($row->br_tanggal)->translatedFormat('d F Y');
                    return $tgl;
                })
                ->addColumn('keterangan', function ($row) {
                    // Mapping ke kolom 'keterangan' untuk ditampilkan di tabel
                    $keterangan = $row->br_keterangan == '' ? '-' : $row->br_keterangan;
                    return $keterangan;
                })
                ->addColumn('barang', function ($row) {
                    $barang = $row->barang_id == '' ? '-' : $row->barang_nama;
                    return $barang;
                })
                ->addColumn('action', function ($row) {
                    $array = array(
                        "br_id" => $row->br_id,
                        "br_kode" => $row->br_kode,
                        "barang_kode" => $row->barang_kode,
                        "br_tanggal" => $row->br_tanggal,
                        "br_keterangan" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->br_keterangan)),
                        "br_jumlah" => $row->br_jumlah
                    );
                    $button = '';
                    $hakEdit = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Rusak', 'tbl_akses.akses_type' => 'update'))->count();
                    $hakDelete = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Rusak', 'tbl_akses.akses_type' => 'delete'))->count();
                    
                    if ($hakEdit > 0 && $hakDelete > 0) {
                        $button .= '
                        <div class="g-2">
                        <a class="btn modal-effect text-primary btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Umodaldemo8" data-bs-toggle="tooltip" data-bs-original-title="Edit" onclick=update(' . json_encode($array) . ')><span class="fe fe-edit text-success fs-14"></span></a>
                        <a class="btn modal-effect text-danger btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Hmodaldemo8" onclick=hapus(' . json_encode($array) . ')><span class="fe fe-trash-2 fs-14"></span></a>
                        </div>
                        ';
                    } else if ($hakEdit > 0 && $hakDelete == 0) {
                        $button .= '
                        <div class="g-2">
                            <a class="btn modal-effect text-primary btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Umodaldemo8" data-bs-toggle="tooltip" data-bs-original-title="Edit" onclick=update(' . json_encode($array) . ')><span class="fe fe-edit text-success fs-14"></span></a>
                        </div>
                        ';
                    } else if ($hakEdit == 0 && $hakDelete > 0) {
                        $button .= '
                        <div class="g-2">
                        <a class="btn modal-effect text-danger btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Hmodaldemo8" onclick=hapus(' . json_encode($array) . ')><span class="fe fe-trash-2 fs-14"></span></a>
                        </div>
                        ';
                    } else {
                        $button .= '-';
                    }
                    return $button;
                })
                ->rawColumns(['action', 'tgl', 'keterangan', 'barang'])->make(true);
        }
    }

    public function proses_tambah(Request $request)
    {
        // Insert data murni (Tanpa mengurangi stok)
        BarangRusakModel::create([
            'br_tanggal'    => $request->tglrusak,
            'br_kode'       => $request->brkode,
            'barang_kode'   => $request->barang,
            'br_keterangan' => $request->keterangan,
            'br_jumlah'     => $request->jml,
            'br_status'     => 'Rusak', 
        ]);

        return response()->json(['success' => 'Berhasil']);
    }

    public function proses_ubah(Request $request, BarangRusakModel $barangrusak)
    {
        // Update data murni
        $barangrusak->update([
            'br_tanggal'    => $request->tglrusak,
            'br_kode'       => $request->brkode,
            'barang_kode'   => $request->barang,
            'br_keterangan' => $request->keterangan,
            'br_jumlah'     => $request->jml,
        ]);

        return response()->json(['success' => 'Berhasil']);
    }

    public function proses_hapus(Request $request, BarangRusakModel $barangrusak)
    {
        try {
            // Hapus data murni
            $barangrusak->delete();

            return response()->json(['success' => 'Berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}