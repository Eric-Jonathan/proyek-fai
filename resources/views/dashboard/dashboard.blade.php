<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    </style>
</head>

<body class="bg-light p-4">
    <div class="container">
        <div class="card shadow rounded-4">
            
            <!-- Header -->
            <div class="header-bar">
                <h4 class="fw-bold mb-0">
                    <i class="bi bi-file-earmark-text"></i> Preview Surat Tugas
                </h4>
            </div>

            <div class="card-body p-4">

                <!-- Status -->
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">
                    <i class="bi bi-hourglass-split"></i> Menunggu Persetujuan
                    <i class="bi bi-hourglass-split"></i> sifat
                </span>

                <!-- Detail Surat -->
                <h5 class="fw-semibold">Detail Surat</h5>
                <div class="mt-2 p-3 border rounded detail-box">
                    <p><strong>Judul Surat:</strong> Kegiatan Monitoring Lapangan</p>
                    <p><strong>Pengaju:</strong> Budi Setiawan</p>
                    <p><strong>Jenis Tugas:</strong> Budi Setiawan</p>
                    <p><strong>Tanggal Pengajuan:</strong> 22 November 2025</p>
                    <p>"tanggal mulai - tanggal selesai" - jam</p>
                    <p><strong>Dasar tugas:</strong> Permohonan surat tugas untuk monitoring kegiatan di lapangan.</p>
                    <p><strong>Tujuan:</strong> Permohonan surat tugas untuk monitoring kegiatan di lapangan.</p>
                    <p><strong>Lampiran:</strong> <a href="#">Lihat Lampiran</a></p>
                </div>

                <hr class="my-4">

                <!-- Notes Penolakan -->
                <div id="notesSection" class="mb-3 d-none">
                    <h5 class="fw-semibold">Alasan Penolakan</h5>
                    <textarea class="form-control" rows="4" placeholder="Tuliskan alasan penolakan..."></textarea>
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end gap-3">
                    <button class="btn btn-danger px-4" onclick="showNotes()">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                    <button class="btn btn-success px-4">
                        <i class="bi bi-check-circle"></i> ACC
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function showNotes() {
            document.getElementById('notesSection').classList.remove('d-none');
        }
    </script>

</body>
</html>
