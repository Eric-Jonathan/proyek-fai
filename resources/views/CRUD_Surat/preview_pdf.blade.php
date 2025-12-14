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

            /* Styling untuk Kop Surat */
            background-image: url('{{ asset("asset/kop_surat.png") }}');
            background-repeat: no-repeat;
            background-size: 100% 100%; 
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

        /* TTD Styling */
        .foot {
            margin-top: 20mm;
            text-align: right;
            padding-right: 5mm;
            /* **PENYESUAIAN PENTING UNTUK STAMPEL OVERLAY** */
            position: relative; 
            height: 200px; /* Tambahkan tinggi agar stempel tidak keluar */
        }
        
        .tandaTangan img {
            width: 140px; 
            height: auto;
            display: inline-block;
            margin: 5px 0;
            position: relative; /* Pastikan TTD ada di Z-index yang benar */
            z-index: 2; 
        }

        /* **CSS BARU UNTUK STAMPEL OVERLAY** */
        .stamp-overlay {
            position: absolute;
            width: 180px;         /* Ukuran Stempel */
            height: 180px; 
            top: 5px;             /* Jarak dari atas div .foot */
            right: 150px;         /* Jarak dari kanan div .foot */
            z-index: 3;           /* Di atas TTD */
            pointer-events: none; /* Agar tidak mengganggu klik/seleksi teks di belakangnya */
        }
        
        .stamp-image {
            width: 100%;
            height: 100%;
            opacity: 0.7; /* Efek tembus pandang */
        }
        /* **AKHIR CSS BARU** */

    </style>
@endsection

@section('content')

    <div class="d-flex justify-content-between mb-3">
        <h4>Preview Surat Tugas</h4>
        <div class="d-flex gap-2">
            
            {{-- Tombol Action (Setuju/Tolak) hanya muncul di halaman preview, bukan cetak --}}
            @if (request()->routeIs('surat.preview'))
                <form method="POST" action="{{ route('surat.tolak', $surat->surat_id) }}" class="d-flex gap-2">
                    @csrf
                    <div id="notesSection" class="d-none d-flex align-items-start gap-2">
                        <textarea 
                            id="textareaPenolakan"
                            name="catatan_penolakan"
                            class="form-control"
                            placeholder="Tuliskan alasan penolakan..."
                            rows="3"
                            style="text-align: left; vertical-align: top; padding-left: 8px;"
                        ></textarea>
                        <div class="d-flex flex-column gap-2">
                            <button type="button" class="btn btn-secondary" onclick="cancelTolak()">Cancel</button>
                            <button id="btnSubmitTolak" type="submit" class="btn btn-danger">Konfirmasi</button>
                        </div>
                    </div>

                    <button id="btnTolakAwal" type="button" class="btn btn-danger px-4" onclick="showNotes()">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                </form>

                @if ($userRole == 'dekan')
                    <button id="btnSetujui" type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#ttdModal">
                        <i class="bi bi-check-circle"></i> Setujui & TTD
                    </button>
                @else
                    <form id="formSetujui" method="POST" action="{{ route('surat.acc', $surat->surat_id) }}">
                        @csrf
                        <button id="btnSetujui" type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle"></i> Setujui
                        </button>
                    </form>
                @endif
            @endif
            
            <a href="{{ route('surat.cetak', $surat->nomor_surat) }}" class="btn btn-outline-secondary">
                Download PDF
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="surat">
                <div class="header text-center">
                    <h1 class="fw-bold text-decoration-underline">SURAT TUGAS</h1>
                    <p>Nomor: {{ $surat->nomor_surat ?? "-" }}</p>
                </div>
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
                <div class="closing">
                    <p>Demikian surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.</p>
                </div>
                
                <div class="foot">
                    
                    {{-- **LOGIKA BARU: TAMPILAN STAMPEL OVERLAY** --}}
                    {{-- Stempel hanya tampil jika path-nya ada di database (sudah difinalisasi BAU) --}}
                    @if ($surat->stempel_path)
                        <div class="stamp-overlay">
                            {{-- Gunakan asset() karena ini adalah preview web --}}
                            <img 
                                src="{{ asset($surat->stempel_path) }}" 
                                class="stamp-image" 
                                alt="Stempel Fakultas"
                            >
                        </div>
                    @endif
                    {{-- **AKHIR LOGIKA STAMPEL** --}}

                    <div class="block">
                        {{-- Tanggal Surat --}}
                        <p class="m-0">Surabaya, {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</p>
                        
                        {{-- Jabatan Penandatangan --}}
                        <p>{{ $parentAssignment->position->position_name ?? '-' }}</p>
                        
                        {{-- Area Tanda Tangan (100px agar ada ruang untuk TTD) --}}
                        <div class="tandaTangan" style="height: 100px; text-align: right;">
                            @if ($surat->ttd_dekan)
                                {{-- Tampilkan TTD Dekan yang tersimpan jika ada --}}
                                <img 
                                    src="{{ asset('storage/' . $surat->ttd_dekan) }}" 
                                    alt="Tanda Tangan Dekan" 
                                    width="140" 
                                    style="margin-top: 5px; margin-bottom: 5px; display: inline-block;"
                                >
                            @else
                                {{-- Tampilkan placeholder jika TTD belum ada/disetujui --}}
                                <div style="height: 80px;">&nbsp;</div>
                            @endif
                        </div>
                        
                        {{-- Nama Penandatangan --}}
                        <p class="text-decoration-underline mb-0">{{ $atasan->full_name ?? '-' }}</p>
                        
                        {{-- Jabatan atau NIDN (Asumsi ini adalah baris di bawah nama) --}}
                        <p>{{ $atasan->nidn ?? '-' }}</p> 
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection