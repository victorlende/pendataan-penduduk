<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 2.5cm;
            box-sizing: border-box;
            background: white;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double black;
            padding-bottom: 10px;
        }
        .header h3, .header h2, .header p {
            margin: 0;
        }
        .header h3 {
            font-size: 14pt;
            font-weight: normal;
        }
        .header h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
        }
        .header p {
            font-size: 12pt;
            font-style: italic;
        }
        .content {
            text-align: justify;
        }
        .content p {
            margin-bottom: 10px;
        }
        .table-data {
            width: 100%;
            margin-left: 20px;
            margin-bottom: 20px;
        }
        .table-data td {
            vertical-align: top;
            padding: 2px 0;
        }
        .table-data td:first-child {
            width: 180px;
        }
        .table-data td:nth-child(2) {
            width: 10px;
        }
        .title {
            text-align: center;
            margin-bottom: 30px;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
        }
        .nomor-surat {
            text-align: center;
            margin-top: -25px;
            margin-bottom: 30px;
        }
        .signature {
            margin-top: 50px;
            float: right;
            width: 250px;
            text-align: center;
        }
        @media print {
            body {
                background: none;
            }
            .container {
                width: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
            @page {
                size: A4;
                margin: 2.5cm;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>PEMERINTAH KABUPATEN TIMOR TENGAH SELATAN</h3>
            <h3>KECAMATAN FATUKOPA</h3>
            <h2>DESA NAISAU</h2>
            <p>Alamat: Jl. Raya Desa Naisau, Kec. Fatukopa, Kab. TTS, Kode Pos 85561</p>
        </div>

        <div class="content">
            @yield('surat_content')
        </div>

        <div class="signature">
            <p>Naisau, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Desa Naisau</p>
            <br><br><br><br>
            <p class="fw-bold" style="text-decoration: underline; font-weight: bold;">( ..................................... )</p>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
