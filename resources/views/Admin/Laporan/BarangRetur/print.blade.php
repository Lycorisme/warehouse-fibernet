<!DOCTYPE html>
<html lang="en">
<?php use Carbon\Carbon; ?>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        * { font-family: Arial, sans-serif; }
        #table1 { border-collapse: collapse; width: 100%; margin-top: 20px; }
        #table1 td, #table1 th { border: 1px solid #ddd; padding: 8px; font-size: 11px; }
        #table1 th { background-color: #f2f2f2; text-align: left; }
    </style>
</head>
<body onload="window.print()">
    <center>
        @if ($web->web_logo == '' || $web->web_logo == 'default.png')
            <img src="{{ url('/assets/default/web/default.png') }}" width="80px">
        @else
            <img src="{{ asset('storage/web/' . $web->web_logo) }}" width="80px">
        @endif
        <h2>Laporan Barang Retur</h2>
        <h4>{{ $tglawal ? Carbon::parse($tglawal)->translatedFormat('d F Y') . ' - ' . Carbon::parse($tglakhir)->translatedFormat('d F Y') : 'Semua Tanggal' }}</h4>
    </center>
    <table id="table1">
        <thead>
            <tr>
                <th width="1%">NO</th>
                <th>TGL RETUR</th>
                <th>KODE RETUR</th>
                <th>KODE BARANG</th>
                <th>BARANG</th>
                <th>JENIS</th>
                <th>JUMLAH</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach ($data as $d)
                <tr>
                    <td align="center">{{ $no++ }}</td>
                    <td>{{ $d->retur_tanggal ? Carbon::parse($d->retur_tanggal)->translatedFormat('d F Y') : '-' }}</td>
                    <td>{{ $d->retur_kode }}</td>
                    <td>{{ $d->barang_kode }}</td>
                    <td>{{ $d->barang_nama }}</td>
                    <td>{{ $d->jenisbarang_nama }}</td>
                    <td align="center">{{ $d->retur_jumlah }}</td>
                    <td>{{ $d->retur_keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>