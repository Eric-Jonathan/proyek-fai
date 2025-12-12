@extends('layouts.app')

@section('custom_css')
    <style>
        body {
            background: #f5f5f5;
        }

        .surat {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 160px 25mm 20mm 25mm;  

            background-image: url('{{ asset("asset/kop_surat.png") }}');
            background-repeat: no-repeat;
            background-size: 100% 100%; /* PNG sudah ukuran A4, aman */
            background-position: top center;

            font-family: "Times New Roman", serif;
            font-size: 12pt;
            box-shadow: 0 0 5px rgba(0,0,0,.2);
        }

        h1 {
            font-size: 20pt;
            margin-bottom: 0;
        }

        .header {
            margin: 0 0 10px 0;
            text-align: left;
        }

        .nomor {
            margin-top: 3px;
            text-align: center;
            font-size: 12pt;
        }

        p, td {
            font-size: 12pt;
        }

        .contain{
            margin-left: 0 !important;
        }

        .contain p {
            text-indent: 0;
            margin-left: 2mm;
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
            width: 40mm;
        }

        td:nth-child(2) {
            width: 5mm;
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
            justify-contain: end;
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

        .foot {
            margin-top: 20mm;
            text-align: right;
            padding-right: 5mm;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Preview Surat Tugas</h4>
        <a href="{{ route('cetak-surat', $surat->nomor_surat) }}" class="btn btn-outline-secondary">
            Download PDF
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="surat">
                <!-- Header -->
                <div class="header text-center">
                    <h1 class="fw-bold text-decoration-underline">SURAT TUGAS</h1>
                    <p>Nomor: {{ $surat->nomor_surat ?? "-" }}</p>
                </div>
                <!-- Isi -->
                <div class="contain mt-3">
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
                            <img src="{{ asset("asset/dummy_ttd.png") }}" width="120">
                        </div>
                        <p class="text-decoration-underline mb-0">{{ $atasan->full_name ?? '-' }}</p>
                        <p>{{ $parentAssignment->position->position_name ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection