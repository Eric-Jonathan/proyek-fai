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
        
        #signatureCanvas {
            touch-action: none; 
        }
    </style>
</head>

<body class="bg-light p-4">
    <div class="container">
        <div class="card shadow rounded-4">
            <div class="header-bar d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0">
                    <i class="bi bi-file-earmark-text"></i> Preview Surat Tugas
                </h4>

                @php
                    $previous = url()->previous();
                    $current  = url()->current();
                    $fallback = route(session('user.role') . '.dashboard');

                    $backUrl = ($previous && $previous !== $current) ? $previous : $fallback;
                @endphp
                <a href="{{ route(session('user.role') . '.dashboard') }}" class="btn btn-kembali">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

            </div>

            <div class="card-body p-4">
                @php
                    // Ambil peran user saat ini
                    $userRole = session('user.role') ?? 'guest'; 
                    // Pastikan variabel $surat tersedia dan memiliki status_surat
                    $statusValue = $surat->status_surat ?? 1;

                    $statusMapping = [
                        -1 => 'Dihapus',
                        0  => 'Ditolak',
                        1  => 'Diajukan',
                        2  => 'Disetujui Kaprodi',
                        3  => 'Disetujui Sekretaris',
                        4  => 'Disetujui Dekan',
                        5  => 'Stempel BAA', 
                        6  => 'Selesai',
                    ];
                                        
                    $badgeClassMapping = [
                        -1 => 'bg-secondary text-white',
                        0  => 'bg-danger text-white',
                        1  => 'bg-warning text-dark',
                        2  => 'bg-info text-dark',
                        3  => 'bg-primary text-white',
                        4  => 'bg-primary text-white',
                        5  => 'bg-dark text-white',
                        6  => 'bg-success text-white',
                    ];
                                        
                    $iconMapping = [
                        -1 => 'bi-trash-fill',
                        0  => 'bi-x-circle-fill',
                        1  => 'bi-send-fill',
                        2  => 'bi-person-check-fill',
                        3  => 'bi-hourglass-split',
                        4  => 'bi-award-fill',
                        5  => 'bi-patch-check-fill',
                        6  => 'bi-check2-circle',
                    ];
                                        
                    $statusText = $statusMapping[$statusValue] ?? 'Status Tidak Dikenal';
                    $badgeClass = $badgeClassMapping[$statusValue] ?? 'bg-secondary';
                    $iconClass = $iconMapping[$statusValue] ?? 'bi-question-circle';
                @endphp

                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <span class="badge {{ $badgeClass }} mb-3 px-3 py-2">
                            <i class="bi {{ $iconClass }}"></i>
                            {{ $statusText }}
                        </span>
        
                        <span class="badge bg-info text-dark mb-3 px-3 py-2">
                            <i class="bi bi-flag"></i>
                            {{ $surat->sifat ?? '-' }}
                        </span>
                        
                        @if ($surat->nomor_surat)
                            <span class="badge bg-secondary mb-3 px-3 py-2">
                                <i class="bi bi-hash"></i>
                                Nomor Surat: {{ $surat->nomor_surat }}
                            </span>
                        @endif
                    </div>
                    @if ($surat->sifat == 'Dinas')
                        <a href="{{ route('surat.preview_pdf', $surat->surat_id) }}" class="btn btn-primary px-3 py-2"><i class="fe fe-eye"></i> Lihat Surat</a>
                    @endif
                </div>

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
                        ({{ $surat->waktu_pelaksanaan }})
                    </p>

                    <p><strong>Dasar Tugas:</strong> {{ $surat->dasar_tugas }}</p>
                    <p><strong>Tujuan Tugas:</strong> {{ $surat->tujuan }}</p>

                    <p><strong>Lampiran:</strong>
                        @if(!empty($surat->lampiran_path))
                            <a href="{{ asset('storage/' . $surat->lampiran_path) }}" target="_blank">
                                Lihat Lampiran
                            </a>
                        @else
                            <span class="text-muted">Tidak ada lampiran</span>
                        @endif
                    </p>
                    
                    @if ($surat->stempel_path)
                        <p><strong>Status Final:</strong> 
                            <span class="badge bg-success">Sudah Distempel</span>
                            <small class="text-muted">(Siap Cetak)</small>
                        </p>
                    @endif

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end align-items-start gap-3 mt-4">

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
                        @if ($statusValue < 5)
                            <button 
                                id="btnTolakAwal"
                                type="button"
                                class="btn btn-danger px-4"
                                onclick="showNotes()">
                                <i class="bi bi-x-circle"></i> Tolak
                            </button>
                        @endif

                    </form>
                    
                    @if ($userRole == 'dekan' && $statusValue < 4)
                        {{-- DEKAN: TTD --}}
                        <button 
                            id="btnSetujui" 
                            type="button" 
                            class="btn btn-success px-4" 
                            data-bs-toggle="modal" 
                            data-bs-target="#ttdModal"
                        >
                            <i class="bi bi-check-circle"></i> Setujui & TTD
                        </button>
                    @elseif($userRole == 'rektor' && $statusValue == 4)
                        {{-- REKTOR: TTD --}}
                        <button 
                            id="btnSetujui" 
                            type="button" 
                            class="btn btn-success px-4" 
                            data-bs-toggle="modal" 
                            data-bs-target="#ttdModal"
                        >
                            <i class="bi bi-check-circle"></i> Setujui & TTD
                        </button>

                    @elseif ($userRole == 'bau' && ($statusValue == 4 || $statusValue == 5) && !$surat->stempel_path)
                        {{-- BAU: Tambahkan Stempel dan Selesaikan (jika Dekan sudah TTD dan belum distempel) --}}
                        <form id="formStempel" method="POST" action="{{ route('surat.acc', $surat->surat_id) }}">
                            @csrf
                            <input type="hidden" name="action_type" value="stempel">
                            <button id="btnStempel" type="submit" class="btn btn-dark px-4">
                                <i class="bi bi-patch-check"></i> Tambahkan Stempel & Selesaikan
                            </button>
                        </form>
                        
                    @elseif ($statusValue < 4)
                        {{-- KAPRODI/SEKRETARIS: Setujui Biasa --}}
                        <form id="formSetujui" method="POST" action="{{ route('surat.acc', $surat->surat_id) }}">
                            @csrf
                            <button id="btnSetujui" type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-circle"></i> Setujui
                            </button>
                        </form>

                    @elseif ($statusValue == 4)
                        {{-- KAPRODI/SEKRETARIS: Setujui Biasa --}}
                        <form id="formSetujui" method="POST" action="{{ route('surat.acc', $surat->surat_id) }}">
                            @csrf
                            <button id="btnSetujui" type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-circle"></i> Setujui
                            </button>
                        </form>
                    
                    @elseif ($statusValue == 6)
                        {{-- AKSI TAMBAHAN JIKA SUDAH SELESAI --}}
                         <a href="{{ route('surat.cetak', $surat->surat_id) }}" target="_blank" class="btn btn-primary px-4">
                        
                            <i class="bi bi-printer"></i> Cetak PDF
                        </a>
                        
                    @endif

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="ttdModal" tabindex="-1" aria-labelledby="ttdModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="ttdModalLabel"><i class="bi bi-pen"></i> Tanda Tangan Digital Dekan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form id="formSetujuiTTD" method="POST" action="{{ route('surat.acc', $surat->surat_id) }}">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted">Gambarkan Tanda Tangan Anda di area kanvas di bawah ini:</p>
                        
                        <div class="border border-dark rounded mb-3">
                            <canvas id="signatureCanvas" style="width: 100%; height: 200px;"></canvas>
                        </div>

                        <input type="hidden" name="ttd_base64" id="ttdBase64Input" required>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" id="clearSignature" class="btn btn-warning"><i class="bi bi-eraser"></i> Hapus TTD</button>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" id="submitSignature" class="btn btn-success" disabled>
                                <i class="bi bi-check-circle"></i> Konfirmasi Setuju
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    
    <script>
        // Fungsi untuk menampilkan/menyembunyikan form penolakan (TIDAK BERUBAH)
        function showNotes() {
            const notes = document.getElementById('notesSection');
            const btnTolakAwal = document.getElementById('btnTolakAwal');
            const btnSetujui = document.getElementById('btnSetujui');
            const btnStempel = document.getElementById('btnStempel'); // Tambah
            const textarea = document.getElementById('textareaPenolakan');

            notes.classList.remove('d-none');
            btnTolakAwal.classList.add('d-none');
            
            if (btnSetujui) { btnSetujui.classList.add('d-none'); }
            if (btnStempel) { btnStempel.classList.add('d-none'); } // Tambah

            textarea.setAttribute('required', 'required');
        }

        function cancelTolak() {
            const notes = document.getElementById('notesSection');
            const btnTolakAwal = document.getElementById('btnTolakAwal');
            const btnSetujui = document.getElementById('btnSetujui');
            const btnStempel = document.getElementById('btnStempel'); // Tambah
            const textarea = document.getElementById('textareaPenolakan');

            notes.classList.add('d-none');
            btnTolakAwal.classList.remove('d-none');
            
            if (btnSetujui) { btnSetujui.classList.remove('d-none'); }
            if (btnStempel) { btnStempel.classList.remove('d-none'); } // Tambah

            textarea.removeAttribute('required');
            textarea.value = '';
        }
        
        // LOGIKA TANDA TANGAN MANUAL (TIDAK ADA PERUBAHAN)
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signatureCanvas');
            if (!canvas) return; 
            
            const clearButton = document.getElementById('clearSignature');
            const submitButton = document.getElementById('submitSignature');
            const ttdBase64Input = document.getElementById('ttdBase64Input');
            const formSetujuiTTD = document.getElementById('formSetujuiTTD');

            // 1. Inisialisasi Signature Pad
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)', 
                penColor: 'rgb(0, 0, 0)'
            });

            // 2. Adjust Canvas Size 
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1); 
                const data = signaturePad.toData(); 
                
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                
                signaturePad.fromData(data);
                
                if(signaturePad.isEmpty()) {
                    submitButton.setAttribute('disabled', 'disabled');
                }
            }
            
            var ttdModal = document.getElementById('ttdModal')
            ttdModal.addEventListener('shown.bs.modal', function () {
                resizeCanvas();
            })

            resizeCanvas(); 

            // 3. Kontrol Tombol Submit 
            signaturePad.addEventListener('endStroke', () => {
                submitButton.removeAttribute('disabled');
            });
            signaturePad.addEventListener('clear', () => {
                submitButton.setAttribute('disabled', 'disabled');
                ttdBase64Input.value = '';
            });

            // 4. Tombol Hapus
            clearButton.addEventListener('click', () => {
                signaturePad.clear();
            });

            // 5. Submit Form
            formSetujuiTTD.addEventListener('submit', function(e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert("Tanda tangan tidak boleh kosong!");
                    return;
                }
                
                const dataURL = signaturePad.toDataURL("image/png");
                ttdBase64Input.value = dataURL; 
            });
        });
    </script>

</body>
</html>