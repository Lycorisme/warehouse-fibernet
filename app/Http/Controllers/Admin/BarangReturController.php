<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\BarangReturModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BarangReturController extends Controller
{
    public function index()
    {
        $data["title"] = "Barang Retur";
        $data["hakTambah"] = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')
            ->where(array(
                'tbl_akses.role_id' => Session::get('user')->role_id, 
                'tbl_submenu.submenu_judul' => 'Barang Retur', 
                'tbl_akses.akses_type' => 'create'
            ))->count();
            
        return view('Admin.BarangRetur.index', $data);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            // Join ke tabel barang untuk mengambil nama barang
            $data = BarangReturModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangretur.barang_kode')
                ->orderBy('retur_id', 'DESC')
                ->get();
                
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl', function ($row) {
                    $tgl = $row->retur_tanggal == '' ? '-' : Carbon::parse($row->retur_tanggal)->translatedFormat('d F Y');
                    return $tgl;
                })
                ->addColumn('keterangan', function ($row) {
                    $keterangan = $row->retur_keterangan == '' ? '-' : $row->retur_keterangan;
                    return $keterangan;
                })
                ->addColumn('barang', function ($row) {
                    $barang = $row->barang_id == '' ? '-' : $row->barang_nama;
                    return $barang;
                })
                ->addColumn('action', function ($row) {
                    $array = array(
                        "retur_id" => $row->retur_id,
                        "retur_kode" => $row->retur_kode,
                        "barang_kode" => $row->barang_kode,
                        "retur_tanggal" => $row->retur_tanggal,
                        // Membersihkan karakter khusus agar JS tidak error
                        "retur_keterangan" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->retur_keterangan)),
                        "retur_jumlah" => $row->retur_jumlah
                    );
                    
                    $button = '';
                    $hakEdit = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Retur', 'tbl_akses.akses_type' => 'update'))->count();
                    $hakDelete = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Retur', 'tbl_akses.akses_type' => 'delete'))->count();
                    
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
        // Insert Data Murni (Tanpa Transaksi Stok)
        BarangReturModel::create([
            'retur_tanggal'     => $request->tglretur,
            'retur_kode'        => $request->returkode,
            'barang_kode'       => $request->barang,
            'retur_keterangan'  => $request->keterangan,
            'retur_jumlah'      => $request->jml,
        ]);

        return response()->json(['success' => 'Berhasil']);
    }

    public function proses_ubah(Request $request, BarangReturModel $barangretur)
    {
        // Update Data Murni
        $barangretur->update([
            'retur_tanggal'     => $request->tglretur,
            'retur_kode'        => $request->returkode,
            'barang_kode'       => $request->barang,
            'retur_keterangan'  => $request->keterangan,
            'retur_jumlah'      => $request->jml,
        ]);

        return response()->json(['success' => 'Berhasil']);
    }

    public function proses_hapus(Request $request, BarangReturModel $barangretur)
    {
        try {
            // Hapus Data Murni
            $barangretur->delete();

            return response()->json(['success' => 'Berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}