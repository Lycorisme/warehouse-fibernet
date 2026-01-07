<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\JenisbarangModel; // Tambahkan ini
use App\Models\Admin\WebModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class LapBarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Lap Barang Keluar";
        // Ambil data jenis untuk dropdown filter
        $data["jenis"] = JenisbarangModel::orderBy('jenisbarang_nama', 'ASC')->get();
        return view('Admin.Laporan.BarangKeluar.index', $data);
    }

    public function print(Request $request)
    {
        // 1. Definisikan Query Awal dengan Join ke Jenis Barang
        $query = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id') // Join Jenis
            ->select('tbl_barangkeluar.*', 'tbl_barang.barang_nama', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('bk_id', 'DESC');

        // 2. Filter Tanggal
        if ($request->tglawal) {
            $query->whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir]);
        }

        // 3. Filter Nama Barang
        if ($request->filled('search_nama')) {
            $query->where('tbl_barang.barang_nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        // --- TAMBAHAN: Filter Jenis Barang ---
        if ($request->filled('filter_jenis')) {
            $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
        }

        $data['data'] = $query->get();
        $data["title"] = "Print Barang Keluar";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        
        return view('Admin.Laporan.BarangKeluar.print', $data);
    }

    public function pdf(Request $request)
    {
        $query = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id') // Join Jenis
            ->select('tbl_barangkeluar.*', 'tbl_barang.barang_nama', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('bk_id', 'DESC');

        if ($request->tglawal) {
            $query->whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir]);
        }

        if ($request->filled('search_nama')) {
            $query->where('tbl_barang.barang_nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        // --- TAMBAHAN: Filter Jenis Barang ---
        if ($request->filled('filter_jenis')) {
            $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
        }

        $data['data'] = $query->get();
        $data["title"] = "PDF Barang Keluar";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        
        $pdf = PDF::loadView('Admin.Laporan.BarangKeluar.pdf', $data)->setPaper('a4', 'landscape');
        
        if($request->tglawal){
            return $pdf->download('lap-bk-'.$request->tglawal.'-'.$request->tglakhir.'.pdf');
        }else{
            return $pdf->download('lap-bk-semua-tanggal.pdf');
        }
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $query = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')
                ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id') // Join Jenis
                ->select('tbl_barangkeluar.*', 'tbl_barang.barang_nama', 'tbl_barang.barang_id', 'tbl_jenisbarang.jenisbarang_nama')
                ->orderBy('bk_id', 'DESC');

            // Filter Tanggal
            if ($request->filled('tglawal')) {
                $query->whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir]);
            }

            // Filter Nama Barang
            if ($request->filled('search_nama')) {
                $query->where('tbl_barang.barang_nama', 'LIKE', '%' . $request->search_nama . '%');
            }

            // --- TAMBAHAN: Filter Jenis Barang ---
            if ($request->filled('filter_jenis')) {
                $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl', function ($row) {
                    return $row->bk_tanggal == '' ? '-' : Carbon::parse($row->bk_tanggal)->translatedFormat('d F Y');
                })
                ->addColumn('barang', function ($row) {
                    return $row->barang_nama ?? '-';
                })
                // --- TAMBAHAN DATA JENIS UNTUK DATATABLE ---
                ->addColumn('jenisbarang_nama', function ($row) {
                    return $row->jenisbarang_nama ?? '-';
                })
                ->addColumn('tujuan', function ($row) {
                    return $row->bk_tujuan;
                })
                ->rawColumns(['tgl', 'barang', 'jenisbarang_nama', 'tujuan'])
                ->make(true);
        }
    }
}