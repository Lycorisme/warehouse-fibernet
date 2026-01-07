<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\JenisbarangModel; // Tambahkan ini
use App\Models\Admin\WebModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class LapBarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Lap Barang Masuk";
        // Mengambil data jenis untuk dropdown filter di view
        $data["jenis"] = JenisbarangModel::orderBy('jenisbarang_nama', 'ASC')->get();
        return view('Admin.Laporan.BarangMasuk.index', $data);
    }

    public function print(Request $request)
    {
        // 1. Definisikan Query Awal dengan Join ke Jenis Barang
        $query = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')
            ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id') // Join Jenis
            ->select('tbl_barangmasuk.*', 'tbl_barang.barang_nama', 'tbl_customer.customer_nama', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('bm_id', 'DESC');

        // 2. Filter Tanggal
        if ($request->tglawal) {
            $query->whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir]);
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

        $data["title"] = "Print Barang Masuk";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        
        return view('Admin.Laporan.BarangMasuk.print', $data);
    }

    public function pdf(Request $request)
    {
        $query = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')
            ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id') // Join Jenis
            ->select('tbl_barangmasuk.*', 'tbl_barang.barang_nama', 'tbl_customer.customer_nama', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('bm_id', 'DESC');

        if ($request->tglawal) {
            $query->whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir]);
        }

        if ($request->filled('search_nama')) {
            $query->where('tbl_barang.barang_nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        // --- TAMBAHAN: Filter Jenis Barang ---
        if ($request->filled('filter_jenis')) {
            $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
        }

        $data['data'] = $query->get();

        $data["title"] = "PDF Barang Masuk";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        
        $pdf = PDF::loadView('Admin.Laporan.BarangMasuk.pdf', $data)->setPaper('a4', 'landscape');
        
        if($request->tglawal){
            return $pdf->download('lap-bm-'.$request->tglawal.'-'.$request->tglakhir.'.pdf');
        }else{
            return $pdf->download('lap-bm-semua-tanggal.pdf');
        }
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $query = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')
                ->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')
                ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id') // Join Jenis
                ->select('tbl_barangmasuk.*', 'tbl_barang.barang_nama', 'tbl_barang.barang_id', 'tbl_customer.customer_nama', 'tbl_jenisbarang.jenisbarang_nama')
                ->orderBy('bm_id', 'DESC');

            // Filter Tanggal
            if ($request->filled('tglawal')) {
                $query->whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir]);
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
                    return $row->bm_tanggal == '' ? '-' : Carbon::parse($row->bm_tanggal)->translatedFormat('d F Y');
                })
                ->addColumn('customer', function ($row) {
                    return $row->customer_id == '' ? '-' : $row->customer_nama;
                })
                ->addColumn('barang', function ($row) {
                    return $row->barang_nama ?? '-';
                })
                // --- TAMBAHAN FIELD JENIS UNTUK DATATABLE ---
                ->addColumn('jenisbarang_nama', function ($row) {
                    return $row->jenisbarang_nama ?? '-';
                })
                ->rawColumns(['tgl', 'customer', 'barang', 'jenisbarang_nama'])
                ->make(true);
        }
    }
}