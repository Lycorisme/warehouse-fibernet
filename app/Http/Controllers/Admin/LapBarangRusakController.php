<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BarangRusakModel; //
use App\Models\Admin\JenisbarangModel;
use App\Models\Admin\WebModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class LapBarangRusakController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Lap Barang Rusak";
        $data["jenis"] = JenisbarangModel::orderBy('jenisbarang_nama', 'ASC')->get();
        return view('Admin.Laporan.BarangRusak.index', $data);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $query = BarangRusakModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangrusak.barang_kode')
                ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
                ->select('tbl_barangrusak.*', 'tbl_barang.barang_nama', 'tbl_jenisbarang.jenisbarang_nama')
                ->orderBy('br_id', 'DESC');

            if ($request->filled('tglawal')) {
                $query->whereBetween('br_tanggal', [$request->tglawal, $request->tglakhir]);
            }

            if ($request->filled('search_nama')) {
                $query->where('tbl_barang.barang_nama', 'LIKE', '%' . $request->search_nama . '%');
            }

            if ($request->filled('filter_jenis')) {
                $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
            }

            return DataTables::of($query->get())
                ->addIndexColumn()
                ->addColumn('tgl', function ($row) {
                    return $row->br_tanggal == '' ? '-' : Carbon::parse($row->br_tanggal)->translatedFormat('d F Y');
                })
                ->addColumn('barang', function ($row) {
                    return $row->barang_nama ?? '-';
                })
                ->rawColumns(['tgl', 'barang'])
                ->make(true);
        }
    }

    public function print(Request $request)
    {
        $query = BarangRusakModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangrusak.barang_kode')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
            ->select('tbl_barangrusak.*', 'tbl_barang.barang_nama', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('br_id', 'DESC');

        if ($request->tglawal) {
            $query->whereBetween('br_tanggal', [$request->tglawal, $request->tglakhir]);
        }

        if ($request->filled('filter_jenis')) {
            $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
        }

        $data['data'] = $query->get();
        $data["title"] = "Print Barang Rusak";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        
        return view('Admin.Laporan.BarangRusak.print', $data);
    }
}