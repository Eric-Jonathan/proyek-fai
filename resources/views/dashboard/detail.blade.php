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
                @php
                    $status = $surat->status_surat ?? 'Menunggu Persetujuan';

                    switch($status) {
                        case 'ditolak':
                            $badgeClass = 'bg-danger text-white';
                            $iconClass = 'bi-x-circle';
                            break;
                    
                        case 'ditandatangani':
                            $badgeClass = 'bg-success text-white';
                            $iconClass = 'bi-check-circle';
                            break;
                    
                        default:
                            $badgeClass = 'bg-warning text-dark';
                            $iconClass = 'bi-hourglass-split';
                    }
                @endphp

                <!-- Status -->
                <span class="badge {{ $badgeClass }} mb-3 px-3 py-2">
                    <i class="bi {{ $iconClass }}"></i>
                    {{ $status }}
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



                </div>

            </div>
        </div>
    </div>

</body>
</html>
