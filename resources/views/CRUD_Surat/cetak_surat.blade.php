<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas</title>

    <style>
        @page {
            size: A4;
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
        }

        .content {
            padding: 45mm 25mm 20mm 25mm; /* Sesuaikan agar tidak nabrak header/footer */
            font-size: 12pt;
        }

        h1 {
            font-size: 20pt;
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

        table {
            width: 100%;
            margin-top: 12px;
            border-collapse: collapse;
        }

        td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 12pt;
        }

        td:first-child {
            width: 150px;
        }

        td:nth-child(2) {
            width: 10px;
        }

        .closing {
            margin-top: 15px;
            text-align: justify;
        }

        .ttd-container {
            margin-top: 25px;
            width: 100%;
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
    </style>

</head>
<body>

<div class="content">
    <h1>SURAT TUGAS</h1>
    <div class="nomor">Nomor: 923/A6/ISTTS/X/2025</div>

    <p style="text-align: justify; margin-top: 15px;">
        Yang bertanda tangan di bawah ini Dekan Fakultas Sains dan Teknologi, dengan ini memberi tugas kepada:
    </p>

    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>Prof. Dr. Ir. Esther Irawati Setiawan, S.Kom., M.Kom.</td>
        </tr>
        <tr>
            <td>NIDN</td>
            <td>:</td>
            <td>07200984018</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Kaprodi S1 – Sistem Informasi</td>
        </tr>
        <tr>
            <td>Jenis Tugas</td>
            <td>:</td>
            <td>Visiting Profesor dalam memberikan pendampingan “Building LLM Applications with Prompt Engineer”.</td>
        </tr>
        <tr>
            <td>Dasar Tugas</td>
            <td>:</td>
            <td>Surat dari King Mongkut’s University of Technology Thonburi (KMUTT) perihal undangan sebagai visiting investor tanggal 31 Oktober 2025.</td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>:</td>
            <td>Dinas</td>
        </tr>
        <tr>
            <td>Tujuan</td>
            <td>:</td>
            <td>
                Departemen Teknik Komputer, Gedung Wissawa Wattana (S4), KMUTT<br>
                126 Pracha Uthit Rd, Bangkok, Thailand
            </td>
        </tr>
        <tr>
            <td>Waktu Pelaksanaan</td>
            <td>:</td>
            <td>
                Jumat, 31 Oktober 2025<br>
                13.00 – 18.00
            </td>
        </tr>
    </table>

    <p class="closing">
        Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.
    </p>

    <div class="ttd-container">
        <div class="ttd-area">
            <p>Surabaya, 27 Oktober 2025</p>
            <p>Institut Sains dan Teknologi Terpadu Surabaya</p>

            <img src="{{ public_path('asset/dummy_ttd.png') }}" width="110">

            <p class="name">Edwin Pramana</p>
            <p>Dekan Fakultas Sains dan Teknologi</p>
        </div>
    </div>

</div>

</body>
</html>