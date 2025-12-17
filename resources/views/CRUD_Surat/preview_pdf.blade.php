@extends('layouts.app')

@section('custom_css')
    <style>
        /* Container utama untuk mensimulasikan kertas A4 di browser */
        body {
            background: #f5f5f5;
        }

        .surat-container {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,.15);
            box-sizing: border-box;
            position: relative;
        }

        .surat {
            /* Padding disamakan persis dengan PDF */
            padding: 160px 25mm 20mm 25mm; 
            
            /* Styling Kop Surat */
            background-image: url('{{ asset("asset/kop_surat.png") }}');
            background-repeat: no-repeat;
            background-size: 100% auto; 
            background-position: top center;
            
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            color: black;
            line-height: 1.3;
        }

        /* Header Judul */
        .header h1 {
            text-align: center;
            font-weight: bold;
            margin: 0;
            text-decoration: underline;
            font-size: 20pt;
            text-transform: uppercase;
        }

        .header p {
            text-align: center;
            margin: 5px 0 20px 0;
            font-size: 12pt;
        }

        /* Isi Surat */
        .contain p {
            text-align: justify;
            text-indent: 50px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        table td {
            padding: 3px 5px;
            vertical-align: top;
            font-size: 12pt;
        }

        /* Bagian Penutup */
        .closing {
            margin-top: 15px;
        }

        .closing p {
            text-align: justify;
            text-indent: 50px;
            margin-top: 10px;
        }

        /* TTD & Stempel (Bagian paling krusial agar sinkron) */
        .foot {
            margin-top: 15mm;
            text-align: right;
            padding-right: 5mm;
            position: relative;
        }

        .ttd-block {
            display: inline-block;
            text-align: right; 
            width: 300px; /* Ukuran area TTD */
            position: relative;
        }

        /* Stempel menimpa TTD (Overlay) */
        .stamp-overlay {
            position: absolute;
            width: 160px;
            height: 160px;
            top: -20px; /* Atur naik turun stempel */
            left: -10px; /* Atur kiri kanan stempel agar menimpa TTD */
            z-index: 3;
            opacity: 0.8;
            pointer-events: none;
        }

        .stamp-image {
            width: 100%;
            height: 100%;
        }

        .tandaTangan {
            height: 100px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin: 5px 0;
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
            font-weight: bold;
        }

        /* Utility untuk tombol preview */
        .action-bar {
            width: 210mm;
            margin: 20px auto 0 auto;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    
    <div class="action-bar d-flex justify-content-between align-items-center mb-3">
        <h4>Preview Surat Tugas</h4>
        <div class="d-flex gap-2">
            @if (request()->routeIs('surat.preview'))
                <form method="POST" action="{{ route('surat.tolak', $surat->surat_id) }}" class="d-flex gap-2">
                    @csrf
                    <div id="notesSection" class="d-none d-flex align-items-start gap-2">
                        <textarea name="catatan_penolakan" class="form-control" placeholder="Alasan penolakan..." rows="2"></textarea>
                        <div class="d-flex flex-column gap-1">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="cancelTolak()">Batal</button>
                            <button type="submit" class="btn btn-sm btn-danger">Kirim</button>
                        </div>
                    </div>
                    <button id="btnTolakAwal" type="button" class="btn btn-danger" onclick="showNotes()">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                </form>

                @if ($userRole == 'dekan' && $surat->status_surat == 3)
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ttdModal">
                        <i class="bi bi-check-circle"></i> Setujui & TTD
                    </button>
                @else
                    <form method="POST" action="{{ route('surat.acc', $surat->surat_id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Setujui
                        </button>
                    </form>
                @endif
            @endif

            {{-- Pengecekan URL --}}
            @php
                $previous = url()->previous();
                $current  = url()->current();
                $fallback = route(session('user.role') . '.dashboard');

                $backUrl = ($previous && $previous !== $current) ? $previous : $fallback;
            @endphp
            <a href="{{ $backUrl }}" class="btn btn-outline-danger">< Back</a>
            <a href="{{ route('surat.cetak', $surat->surat_id) }}" class="btn btn-outline-secondary">
                <i class="fe fe-download"></i>Download PDF
            </a>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger mx-auto" style="width: 210mm;">{{ session('error') }}</div>
    @endif

    <div class="surat-container">
        <div class="surat">
            
            <div class="header">
                <h1>SURAT TUGAS</h1>
                <p>Nomor: {{ $surat->nomor_surat ?? "-" }}</p>
            </div>

            <div class="contain">
                <p>Yang bertanda tangan di bawah ini {{ $parentAssignment->position->position_name ?? '-' }}, memberi tugas kepada:</p>
                <table>
                    <tr>
                        <td style="width: 150px;">Nama</td>
                        <td style="width: 10px;">:</td>
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
                    
                    {{-- STEMPEL --}}
                    @if ($surat->stempel_path)
                        <div class="stamp-overlay">
                            <img src="{{ asset($surat->stempel_path) }}" class="stamp-image">
                        </div>
                    @endif

                    <div class="block">
                        <p>Surabaya, {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</p>
                        <p>Institut Sains dan Teknologi Terpadu Surabaya</p>
                        
                        <div class="tandaTangan">
                            @if ($surat->ttd_dekan)
                                <img src="{{ asset('storage/' . $surat->ttd_dekan) }}" alt="TTD">
                            @else
                                <div style="height: 100px;">&nbsp;</div>
                            @endif
                        </div>
                        
                        <p class="text-decoration-underline">{{ $atasan->full_name ?? '-' }}</p>
                        <p>{{ $parentAssignment->position->position_name ?? '-' }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function showNotes() {
        document.getElementById('notesSection').classList.remove('d-none');
        document.getElementById('btnTolakAwal').classList.add('d-none');
    }
    function cancelTolak() {
        document.getElementById('notesSection').classList.add('d-none');
        document.getElementById('btnTolakAwal').classList.remove('d-none');
    }
</script>
@endsection