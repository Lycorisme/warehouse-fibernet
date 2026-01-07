<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BarangReturModel;
use App\Models\Admin\JenisbarangModel;
use App\Models\Admin\WebModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class LapBarangReturController extends Controller
{
    public function index(Request $request)
    {
        $data["title"] = "Lap Barang Retur";
        $data["jenis"] = JenisbarangModel::orderBy('jenisbarang_nama', 'ASC')->get();
        return view('Admin.Laporan.BarangRetur.index', $data);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $query = BarangReturModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangretur.barang_kode')
                ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
                ->select('tbl_barangretur.*', 'tbl_barang.barang_nama', 'tbl_jenisbarang.jenisbarang_nama')
                ->orderBy('retur_id', 'DESC');

            if ($request->filled('tglawal')) {
                $query->whereBetween('retur_tanggal', [$request->tglawal, $request->tglakhir]);
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
                    return $row->retur_tanggal == '' ? '-' : Carbon::parse($row->retur_tanggal)->translatedFormat('d F Y');
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
        $query = BarangReturModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangretur.barang_kode')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
            ->select('tbl_barangretur.*', 'tbl_barang.barang_nama', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('retur_id', 'DESC');

        if ($request->tglawal) {
            $query->whereBetween('retur_tanggal', [$request->tglawal, $request->tglakhir]);
        }

        if ($request->filled('search_nama')) {
            $query->where('tbl_barang.barang_nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        if ($request->filled('filter_jenis')) {
            $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
        }

        $data['data'] = $query->get();
        $data["title"] = "Print Barang Retur";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        
        return view('Admin.Laporan.BarangRetur.print', $data);
    }

    public function pdf(Request $request)
    {
        $query = BarangReturModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangretur.barang_kode')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
            ->select('tbl_barangretur.*', 'tbl_barang.barang_nama', 'tbl_jenisbarang.jenisbarang_nama')
            ->orderBy('retur_id', 'DESC');

        if ($request->tglawal) {
            $query->whereBetween('retur_tanggal', [$request->tglawal, $request->tglakhir]);
        }

        if ($request->filled('search_nama')) {
            $query->where('tbl_barang.barang_nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        if ($request->filled('filter_jenis')) {
            $query->where('tbl_jenisbarang.jenisbarang_nama', $request->filter_jenis);
        }

        $data['data'] = $query->get();
        $data["title"] = "PDF Barang Retur";
        $data['web'] = WebModel::first();
        $data['tglawal'] = $request->tglawal;
        $data['tglakhir'] = $request->tglakhir;
        
        $pdf = PDF::loadView('Admin.Laporan.BarangRetur.print', $data)->setPaper('a4', 'landscape');
        
        $filename = $request->tglawal ? 'lap-retur-'.$request->tglawal.'-'.$request->tglakhir : 'lap-retur-semua-tanggal';
        return $pdf->download($filename.'.pdf');
    }
}