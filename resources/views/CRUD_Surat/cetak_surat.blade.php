<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas - {{ $surat->nomor_surat ?? 'Preview' }}</title>
    
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            background-image: url('{{ public_path("asset/kop_surat.png") }}');
            background-repeat: no-repeat;
            background-size: 100% auto;
            background-position: top center;
        }

        .surat {
            padding: 160px 25mm 20mm 25mm; /* top untuk kop surat */
            margin: 0 auto;
            height: auto;
        }

        .header h1 {
            text-align: center;
            font-weight: bold;
            margin: 0;
            text-decoration: underline;
            font-size: 20pt;
        }

        .header p {
            text-align: center;
            margin: 5px 0 20px 0;
        }

        .contain p {
            text-align: justify;
            text-indent: 50px;
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        table td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .closing {
            margin-top: 15px;
        }

        .closing p {
            margin-top: 10px;
            text-align: justify;
            text-indent: 50px;
        }

        .foot {
            margin-top: 10mm;
            text-align: right;
            padding-right: 5mm;
            position: relative;
            width: 100%;
        }

        .ttd-block {
            display: inline-block;
            text-align: right; 
            width: 260px;
            position: relative;
        }

        .tandaTangan {
            height: 100px;
        }

        .stamp-overlay {
            position: absolute;
            width: 150px;
            height: 150px;
            top: 0;
            left: 10px;   /* jarak dari sisi kiri */
            z-index: 3;
            opacity: 0.7;
        }

        .stamp-image {
            width: 100%;
            height: 100%;
        }

        .tandaTangan img {
           width: 240px;
    height: auto;
    display: inline-block;
    position: relative;
    z-index: 2;
    
    /* TRICK CSS: Menghilangkan background putih */
    mix-blend-mode: multiply;
    
    /* Opsional: Mempertegas warna hitam tanda tangan jika agak pudar */
    filter: contrast(150%) brightness(110%);
        }


        .block p {
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .text-decoration-underline {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="surat">
        <div class="header">
            <h1>SURAT TUGAS</h1>
            <p>Nomor: {{ $surat->nomor_surat ?? "-" }}</p>
        </div>

        <div class="contain">
            <p>Yang bertanda tangan di bawah ini {{ $parentAssignment->position->position_name ?? '-' }}, memberi tugas kepada:</p>
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $lecturer->full_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>NIDN</td>
                    <td>:</td>
                    <td>{{ $lecturer->nidn ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $lecturer->activePositions()->first()?->position?->position_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jenis Tugas</td>
                    <td>:</td>
                    <td>{{ $surat->jenis_tugas }}</td>
                </tr>
                <tr>
                    <td>Dasar Tugas</td>
                    <td>:</td>
                    <td>{{ $surat->dasar_tugas }}</td>
                </tr>
                <tr>
                    <td>Sifat</td>
                    <td>:</td>
                    <td>{{ $surat->sifat }}</td>
                </tr>
                <tr>
                    <td>Tujuan</td>
                    <td>:</td>
                    <td>{{ $surat->tujuan }}</td>
                </tr>
                <tr>
                    <td>Waktu Pelaksanaan</td>
                    <td>:</td>
                    <td>{{ $surat->waktu_pelaksanaan }}</td>
                </tr>
            </table>
        </div>

        <div class="closing">
            <p>Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>
        </div>

        <div class="foot">
            <div class="ttd-block">
                @if ($surat->ttd_dekan)
                    <div class="stamp-overlay">
                        <img src="{{ public_path('asset/stempel.png') }}" class="stamp-image" alt="Stempel Fakultas">
                    </div>
                @endif

                <div class="block">
                    <p>Surabaya, {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</p>
                    <p>Institut Sains dan Teknologi Terpadu Surabaya</p>
                    <div class="tandaTangan">
                        @if ($surat->ttd_dekan)
                            <img src="{{ public_path('storage/' . $surat->ttd_dekan) }}" alt="Tanda Tangan Dekan">
                        @else
                            <div style="height: 100px;">&nbsp;</div>
                        @endif
                    </div>
                    <p class="text-decoration-underline mb-0">{{ $atasan->full_name ?? '-' }}</p>
                    <p>{{ $parentAssignment->position->position_name ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
