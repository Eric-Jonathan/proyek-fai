<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Surat Tugas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .header-bar {
            background: linear-gradient(90deg, #0d6efd, #4dabf7);
            color: white;
            padding: 14px 20px;
            border-radius: 12px 12px 0 0;
        }

        .detail-box {
            background: #f8f9fa;
            border-left: 4px solid #0d6efd;
            transition: 0.2s;
        }

        .detail-box:hover {
            background: #eef3ff;
        }

        .stylish-textarea {
            border-radius: 12px;
            border: 1.5px solid #ced4da;
            padding: 12px 14px;
            transition: all 0.25s ease-in-out;
            background: #fafafa;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
        }

        .stylish-textarea:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.25);
            background: #fff;
        }

        .btn-kembali {
            background: #e7f0ff;
            color: #0d6efd;
            border: 1px solid #bdd5ff;
            padding: 8px 18px;
            font-weight: 600;
            border-radius: 50px;
            transition: 0.2s;
        }

        .btn-kembali:hover {
            background: #d8e8ff;
            color: #0a58ca;
            border-color: #aac9ff;
        }
    </style>
</head>

<body class="bg-light p-4">

    <div class="container">
        <div class="card shadow rounded-4">

            <!-- Header -->
            <div class="header-bar d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0">
                    <i class="bi bi-file-earmark-text"></i> Preview Surat Tugas
                </h4>

                <a href="{{ url()->previous() ?? '/surat-tugas' }}" class="btn btn-kembali">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

            </div>

            <div class="card-body p-4">

                <!-- Status -->
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">
                    <i class="bi bi-hourglass-split"></i>
                    {{ $surat->status_surat ?? 'Menunggu Persetujuan' }}
                </span>

                <!-- Sifat -->
                <span class="badge bg-info text-dark mb-3 px-3 py-2">
                    <i class="bi bi-flag"></i>
                    {{ $surat->sifat ?? '-' }}
                </span>

                <!-- Detail Surat -->
                <h5 class="fw-semibold">Detail Surat</h5>

                <div class="mt-2 p-3 border rounded detail-box">

                    <p><strong>Judul Surat:</strong> {{ $surat->jenis_tugas }}</p>
                    <p><strong>Pengaju:</strong> {{ $surat->nama_pengaju }}</p>

                    <p><strong>Jenis Tugas:</strong> 
                        {{ $surat->jenis_tugas ?? '-' }}
                    </p>

                    <p><strong>Tanggal Pengajuan:</strong> 
                        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}
                    </p>

                    <p><strong>Waktu Pelaksanaan:</strong>  
                        {{ $surat->tanggal_mulai }} – {{ $surat->tanggal_selesai }}  
                        ({{ $surat->waktu_pelaksanaan }})
                    </p>

                    <p><strong>Dasar Tugas:</strong> {{ $surat->dasar_tugas }}</p>
                    <p><strong>Tujuan Tugas:</strong> {{ $surat->tujuan }}</p>

                    <p><strong>Lampiran:</strong>
                        @if(!empty($surat->lampiran))
                            <a href="{{ asset('storage/' . $surat->lampiran) }}" target="_blank">Lihat Lampiran</a>
                        @else
                            <span class="text-muted">Tidak ada lampiran</span>
                        @endif
                    </p>

                </div>

                <hr class="my-4">

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end align-items-start gap-3 mt-4">

                    <!-- FORM TOLAK -->
                    <form method="POST" action="{{ route('surat.tolak', $surat->surat_id) }}" class="d-flex gap-2">
                        @csrf

                        <!-- TEXTAREA + BUTTONS -->
                        <div id="notesSection" class="d-none d-flex align-items-start gap-2">
                            <textarea 
                                id="textareaPenolakan"
                                name="catatan_penolakan"
                                class="form-control stylish-textarea"
                                placeholder="Tuliskan alasan penolakan..."
                                rows="3"
                                style="margin-right: 1vw">
                            </textarea>

                            <div class="d-flex flex-column gap-2">
                                <button type="button" class="btn btn-secondary" onclick="cancelTolak()">Cancel</button>
                                <button id="btnSubmitTolak" type="submit" class="btn btn-danger">Konfirmasi</button>
                            </div>
                        </div>

                        <!-- BUTTON TOLAK AWAL -->
                        <button 
                            id="btnTolakAwal"
                            type="button"
                            class="btn btn-danger px-4"
                            onclick="showNotes()">
                            <i class="bi bi-x-circle"></i> Tolak
                        </button>

                    </form>

                    <!-- FORM SETUJUI -->
                    <form id="formSetujui" method="POST" action="{{ route('surat.acc', $surat->surat_id) }}">
                        @csrf
                        <button id="btnSetujui" type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle"></i> Setujui
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        function showNotes() {
            const notes = document.getElementById('notesSection');
            const btnTolakAwal = document.getElementById('btnTolakAwal');
            const btnSetujui = document.getElementById('btnSetujui');
            const textarea = document.getElementById('textareaPenolakan');

            notes.classList.remove('d-none');
            btnTolakAwal.classList.add('d-none');
            btnSetujui.classList.add('d-none');

            textarea.setAttribute('required', 'required');
        }

        function cancelTolak() {
            const notes = document.getElementById('notesSection');
            const btnTolakAwal = document.getElementById('btnTolakAwal');
            const btnSetujui = document.getElementById('btnSetujui');
            const textarea = document.getElementById('textareaPenolakan');

            notes.classList.add('d-none');
            btnTolakAwal.classList.remove('d-none');
            btnSetujui.classList.remove('d-none');

            textarea.removeAttribute('required');
            textarea.value = '';
        }
    </script>

</body>
</html>
