<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Barcode - {{ $data->barang_nama }}</title>
    <style>
        @page {
            size: auto; 
            margin: 0;
        }

        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .responsive-label {
            width: 98%;
            height: 98%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            /* Jarak antar elemen ditingkatkan */
            gap: 8pt; 
        }

        .product-name {
            /* Font diperbesar dari 10pt ke 14pt */
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            font-family: sans-serif;
            line-height: 1.1;
        }

        .barcode-wrapper {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Memaksa batang barcode berwarna hitam saat print */
        .barcode-wrapper div {
            /* background-color: black !important; */
        }

        .barcode-text {
            /* Font diperbesar dari 8pt ke 11pt */
            font-size: 11pt;
            margin-top: 4pt;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            letter-spacing: 1pt;
        }

        .price {
            /* Font diperbesar dari 10pt ke 15pt agar sangat jelas */
            font-size: 15pt;
            font-weight: bold;
            font-family: sans-serif;
            /* border-top: 1px dashed #000; */
            padding-top: 4pt;
            width: 80%;
        }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="position: absolute; top: 0; width: 100%; text-align: center; padding: 10px; background: #eee; border-bottom: 1px solid #ccc; z-index: 9999;">
        <button onclick="window.print()" style="padding: 12px 24px; cursor: pointer; font-weight: bold;">CETAK SEKARANG</button>
        <p style="font-size: 13px; color: red; margin-top: 5px;">PENTING: Jika barcode kosong, centang <b>"Background Graphics"</b> di pengaturan printer.</p>
    </div>

    <div class="responsive-label">
        <!-- 1. Nama Barang -->
        <div class="product-name">{{ $data->barang_nama }}</div>
        
        <!-- 2. Barcode (Skala diperbesar ke 1.5 dan tinggi ke 50) -->
        <div class="barcode-wrapper">
            {!! DNS1D::getBarcodeHTML($data->barang_kode, 'C128', 1.5, 50) !!}
            <div class="barcode-text">{{ $data->barang_kode }}</div>
        </div>

        <!-- 3. Harga -->
        <div class="price">
            Rp {{ number_format($data->barang_harga, 0, ',', '.') }}
        </div>
    </div>

</body>
</html>