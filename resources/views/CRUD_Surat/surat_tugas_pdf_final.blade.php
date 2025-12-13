<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Surat Tugas</title>
    <style>
    /* Hapus background body */

    .surat {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
        /* Hapus box-shadow */
        padding: 160px 25mm 20mm 25mm; 

        /* KRITIS: Ganti asset() dengan public_path() untuk DomPDF */
        background-image: url('{{ public_path("asset/kop_surat.png") }}');
        background-repeat: no-repeat;
        background-size: 100% 100%; 
        background-position: top center;

        font-family: "Times New Roman", serif;
        font-size: 12pt;
    }

    h1 {
        font-size: 20pt;
        margin-bottom: 0;
    }

    .header {
        margin: 0 0 10px 0;
        text-align: center; /* Sesuaikan dengan layout Kop Surat Anda */
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
        position: relative; 
        height: 200px; 
    }
    
    .tandaTangan img {
        width: 140px; 
        height: auto;
        display: inline-block;
        margin: 5px 0;
        position: relative; 
        z-index: 2; 
    }

    /* CSS STAMPEL OVERLAY */
    .stamp-overlay {
        position: absolute;
        width: 180px; 
        height: 180px; 
        top: 5px; 
        right: 150px; 
        z-index: 3; 
        pointer-events: none; 
    }
    
    .stamp-image {
        width: 100%;
        height: 100%;
        opacity: 0.7; 
    }
</style>
</head>
<body>
    <div class="surat">
        <div class="header text-center">
            <h1 class="fw-bold text-decoration-underline">SURAT TUGAS</h1>
            <p>Nomor: {{ $surat->nomor_surat ?? "-" }}</p>
        </div>
        <div class="foot">
            {{-- **LOGIKA BARU: TAMPILAN STAMPEL OVERLAY** --}}
            @if ($surat->stempel_path)
                <div class="stamp-overlay">
                    {{-- KRITIS: Gunakan public_path() di sini karena ini untuk PDF/DomPDF --}}
                    <img 
                        src="{{ public_path($surat->stempel_path) }}" 
                        class="stamp-image" 
                        alt="Stempel Fakultas"
                    >
                </div>
            @endif

            <div class="block">
                <p class="m-0">Surabaya, {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</p>
                <p>{{ $parentAssignment->position->position_name ?? '-' }}</p>
                
                <div class="tandaTangan" style="height: 100px; text-align: right;">
                    @if ($surat->ttd_dekan)
                        {{-- KRITIS: Gunakan storage_path() atau public_path() di sini untuk TTD --}}
                        <img 
                            src="{{ public_path('storage/' . $surat->ttd_dekan) }}" 
                            alt="Tanda Tangan Dekan" 
                            width="140" 
                            style="margin-top: 5px; margin-bottom: 5px; display: inline-block;"
                        >
                    @else
                        <div style="height: 80px;">&nbsp;</div>
                    @endif
                </div>
                
                <p class="text-decoration-underline mb-0">{{ $atasan->full_name ?? '-' }}</p>
                <p>{{ $atasan->nidn ?? '-' }}</p> 
            </div>
        </div>
    </div>
</body>
</html>