<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\WebModel;
use App\Models\Admin\JenisbarangModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class LapStokBarangController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Lap Stok Barang";
        // Mengambil semua jenis barang untuk dropdown filter
        $data["jenis"] = JenisbarangModel::orderBy('jenisbarang_nama', 'ASC')->get();
        return view('Admin.Laporan.StokBarang.index', $data);
    }

    public function print(Request $request)
    {
        $query = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
            ->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
            ->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')
            ->select('tbl_barang.*', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('barang_id', 'DESC');

        // Filter Nama Barang
        if ($request->filled('search_nama')) {
            $query->where('barang_nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        // --- TAMBAHAN FILTER JENIS ---
        if ($request->filled('filter_jenis')) {
            $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
        }

        $data['data'] = $query->get();
        $data["title"] = "Print Stok Barang";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        
        return view('Admin.Laporan.StokBarang.print', $data);
    }

    public function pdf(Request $request)
    {
        $query = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
            ->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
            ->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')
            ->select('tbl_barang.*', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('barang_id', 'DESC');

        if ($request->filled('search_nama')) {
            $query->where('barang_nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        // --- TAMBAHAN FILTER JENIS ---
        if ($request->filled('filter_jenis')) {
            $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
        }

        $data['data'] = $query->get();
        $data["title"] = "PDF Stok Barang";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;

        $pdf = PDF::loadView('Admin.Laporan.StokBarang.pdf', $data)->setPaper('a4', 'landscape');
        
        if($request->tglawal){
            return $pdf->stream('lap-stok-'.$request->tglawal.'-'.$request->tglakhir.'.pdf');
        } else {
            return $pdf->stream('lap-stok-semua-tanggal.pdf');
        }
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $query = BarangModel::leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
                ->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
                ->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')
                ->select('tbl_barang.*', 'tbl_jenisbarang.jenisbarang_nama')
                ->orderBy('barang_id', 'DESC');

            // Filter Nama Barang
            if ($request->filled('search_nama')) {
                $query->where('tbl_barang.barang_nama', 'LIKE', '%' . $request->search_nama . '%');
            }

            // --- TAMBAHAN FILTER JENIS (DROPDOWN) ---
            if ($request->filled('filter_jenis')) {
                $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('stokawal', function ($row) {
                    return '<span>' . $row->barang_stok . '</span>';
                })
                ->addColumn('jmlmasuk', function ($row) use ($request) {
                    if ($request->tglawal == '') {
                        $jmlmasuk = BarangmasukModel::where('barang_kode', $row->barang_kode)->sum('bm_jumlah');
                    } else {
                        $jmlmasuk = BarangmasukModel::whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir])
                            ->where('barang_kode', $row->barang_kode)
                            ->sum('bm_jumlah');
                    }
                    return '<span>' . $jmlmasuk . '</span>';
                })
                ->addColumn('jmlkeluar', function ($row) use ($request) {
                    if ($request->tglawal) {
                        $jmlkeluar = BarangkeluarModel::whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir])
                            ->where('barang_kode', $row->barang_kode)
                            ->sum('bk_jumlah');
                    } else {
                        $jmlkeluar = BarangkeluarModel::where('barang_kode', $row->barang_kode)->sum('bk_jumlah');
                    }
                    return '<span>' . $jmlkeluar . '</span>';
                })
                ->addColumn('totalstok', function ($row) use ($request) {
                    if ($request->tglawal == '') {
                        $jmlmasuk = BarangmasukModel::where('barang_kode', $row->barang_kode)->sum('bm_jumlah');
                        $jmlkeluar = BarangkeluarModel::where('barang_kode', $row->barang_kode)->sum('bk_jumlah');
                    } else {
                        $jmlmasuk = BarangmasukModel::whereBetween('bm_tanggal', [$request->tglawal, $request->tglakhir])->where('barang_kode', $row->barang_kode)->sum('bm_jumlah');
                        $jmlkeluar = BarangkeluarModel::whereBetween('bk_tanggal', [$request->tglawal, $request->tglakhir])->where('barang_kode', $row->barang_kode)->sum('bk_jumlah');
                    }

                    $totalstok = $row->barang_stok + ($jmlmasuk - $jmlkeluar);
                    
                    if ($totalstok == 0) {
                        return '<span>' . $totalstok . '</span>';
                    } else if ($totalstok > 0) {
                        return '<span class="text-success">' . $totalstok . '</span>';
                    } else {
                        return '<span class="text-danger">' . $totalstok . '</span>';
                    }
                })
                ->rawColumns(['stokawal', 'jmlmasuk', 'jmlkeluar', 'totalstok'])
                ->make(true);
        }
    }
}