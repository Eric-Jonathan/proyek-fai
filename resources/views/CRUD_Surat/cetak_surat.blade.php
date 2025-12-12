<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Surat Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
        @page {
            size: A4;
            margin: 2.5cm 2.5cm 2.5cm 2.5cm;
            margin: 0;
        }
        

        body {
            margin: 0;
            padding: 0;

            background-image: url('{{ public_path("asset/kop_surat.png") }}');
            background-repeat: no-repeat;
            background-position: top left;
            background-size: 100% 100%;

            font-family: "Times New Roman", serif;
            background-color: #fff;
        }

        .surat {
            padding: 45mm 25mm 20mm 25mm; /* Sesuaikan agar tidak nabrak header/footer */
            font-size: 12pt;
        }

        h1 {
           font-size: 20pt;
            margin-bottom: 0;
        }

        .header{
            margin-top: 4rem;
            margin: 0;
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
        }

        .nomor {
            margin-top: 3px;
            text-align: center;
           font-size: 12pt;
        }

        p, td {
            font-size: 12pt;
        }

        .content p {
            text-indent: 50px;
            text-align: justify;
        }

        table {
            margin-top: 10px;
            width: 100%;
            margin-top: 12px;
            border-collapse: collapse;
        }

        td {
            padding: 3px 0;
            vertical-align: top;
            padding: 3px 5px;
            font-size: 12pt;
        }

        td:first-child {
            width: 150px;
        }

        td:nth-child(2) {
           width: 10px;
            padding-left: 10px;
        }

        .closing {
            margin-top: 20px;
        }

        .closing p {
            margin-top: 15px;
            text-align: justify;
        }

        .ttd-container {
            margin-top: 25px;
            width: 100%;
            display: flex;
            justify-content: end;
            text-align: right;
        }

        .ttd-area {
            width: 260px;
            display: inline-block;
            text-align: left;
        }

        .ttd-area img {
            margin: 5px 0;
        }

        .name {
            text-decoration: underline;
            margin-bottom: 0;
        }

        .foot{
            text-align: right !important;
            width: 100%;
        }

   </style>
</head>

</head>
<body>
    <div class="surat">

        <!-- Header -->
        <div class="header text-center">
            <h1 class="fw-bold text-decoration-underline">SURAT TUGAS</h1>
            <p>Nomor: {{ $surat->nomor_surat ?? "-" }}</p>
        </div>

        <!-- Isi -->
        <div class="content mt-3">
            <p>Yang bertanda tangan di bawah ini {{ $parentAssignment->position->position_name ?? '-' }}, dengan ini memberi tugas kepada:</p>
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

        <!-- Penutup -->
        <div class="closing">
            <p>Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>
        </div>

        <!-- Tanda tangan -->
        <div class="foot">
            <div class="block">
                <p class="m-0">Surabaya, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Institut Sains dan Teknologi Terpadu Surabaya</p>

                <div class="tandaTangan">
                    <img src="{{ public_path("asset/dummy_ttd.png") }}" width="120">
                </div>

                <p class="text-decoration-underline mb-0">{{ $atasan->full_name ?? '-' }}</p>
                <p>{{ $parentAssignment->position->position_name ?? '-' }}</p>
            </div>
        </div>
    </div>
</body>
</html>