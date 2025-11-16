<!DOCTYPE html>
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
        }
        
        body {
            font-family: "Times New Roman", serif;
            background-color: #fff;
        }

        .surat {
            width: 100%;
            height: 100%;
            min-height: 297mm;
            box-sizing: border-box;
        }

        h1 {
            font-size: 20pt;
            margin-bottom: 0;
        }

        .header{
            margin-top: 4rem;
        }

        .header p {
            margin-top: 0;
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
        }

        table td {
            vertical-align: top;
            padding: 3px 5px;
        }

        table td:nth-child(1) {
            width: 160px; /* agar kolom kiri rata seperti Word */
        }

        table td:nth-child(2) {
            width: 10px;
            padding-left: 10px;
        }

        .closing {
            margin-top: 20px;
            padding-left: 0;
            margin-left: 0;
        }

        .closing p {
            text-align: justify;
        }

        .foot {
            margin-top: 40px;
            width: 100%;
            display: flex;
            justify-content: end;
        }

        .foot div {
            width: 260px;
            text-align: left;
        }

        .tandaTangan img {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <img src="{{ asset('asset/kop_surat.png') }}" 
     style="position:absolute; top:0; left:0; width:100%; height:auto; z-index:-1;">
    <div class="surat">

        <!-- Header -->
        <div class="header text-center">
            <h1 class="fw-bold text-decoration-underline">SURAT TUGAS</h1>
            <p>Nomor: 923/A6/ISTTS/X/2025</p>
        </div>

        <!-- Isi -->
        <div class="content mt-3">
            <p>Yang bertanda tangan di bawah ini Dekan Fakultas Sains dan Teknologi, dengan ini memberi tugas kepada:</p>

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
                    <td>Visiting Profesor dalam memberikan pendampingan “Building LLM Applications with Prompt Engineer”</td>
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
        </div>

        <!-- Penutup -->
        <div class="closing">
            <p>Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>
        </div>

        <!-- Tanda tangan -->
        <div class="foot">
            <div class="block">
                <p class="m-0">Surabaya, 27 Oktober 2025</p>
                <p>Institut Sains dan Teknologi Terpadu Surabaya</p>

                <div class="tandaTangan">
                    <img src="https://www.indorentalmedia.com/wp-content/uploads/2022/10/cara-scan-tanda-tangan-1200x900.webp" width="120">
                </div>

                <p class="text-decoration-underline mb-0">Edwin Pramana</p>
                <p>Dekan Fakultas Sains dan Teknologi</p>
            </div>
        </div>

    </div>
</body>
</html>