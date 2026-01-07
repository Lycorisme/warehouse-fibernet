<!DOCTYPE html>
<html lang="en">

<?php
use Carbon\Carbon;
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $web->web_deskripsi ?? '' }}">
    <meta name="author" content="{{ $web->web_nama ?? '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- FAVICON -->
    @if (isset($web) && ($web->web_logo == '' || $web->web_logo == 'default.png'))
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/assets/default/web/default.png') }}" />
    @elseif(isset($web))
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/web/' . $web->web_logo) }}" />
    @endif

    <title>{{ $title }}</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        #table1 {
            border-collapse: collapse;
            width: 100%;
            margin-top: 32px;
        }

        #table1 td,
        #table1 th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table1 th {
            padding-top: 12px;
            padding-bottom: 12px;
            color: black;
            font-size: 12px;
            background-color: #f2f2f2;
            /* Warna latar abu-abu muda untuk header */
            font-weight: bold;
        }

        #table1 td {
            font-size: 11px;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-bold {
            font-weight: 600;
        }

        .text-center {
            text-align: center;
        }
    </style>

</head>

<body onload="window.print()">

    <center>
        {{-- LOGO WEBSITE --}}
        @if (isset($web) && ($web->web_logo == '' || $web->web_logo == 'default.png'))
            <img src="{{ url('/assets/default/web/default.png') }}" width="80px" alt="Logo">
        @elseif(isset($web))
            <img src="{{ asset('storage/web/' . $web->web_logo) }}" width="80px" alt="Logo">
        @endif
    </center>

    <center>
        <h1 class="font-medium" style="margin-bottom: 5px;">Laporan Data Supplier</h1>
        <h4 class="font-medium" style="margin-top: 0;">Semua Data</h4>
    </center>

    <table border="1" id="table1">
        <thead>
            <tr>
                <th width="5%" class="text-center">NO</th>
                <th>NAMA SUPPLIER</th>
                <th>NO TELEPON</th>
                <th>ALAMAT</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach ($data as $d)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $d->customer_nama }}</td>
                    <td>{{ $d->customer_notelp }}</td>
                    <td>{{ $d->customer_alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
