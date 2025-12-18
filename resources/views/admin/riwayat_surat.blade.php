
@extends('layouts.app')

@section('title', 'Riwayat Surat')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Surat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-title {
            color: #002060;
            font-weight: 700;
        }

        /* Card Kuning */
        .action-card {
            background: linear-gradient(90deg, #ffc107 0%, #ffca2c 100%);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s ease;
            color: #000;
            text-decoration: none;
        }
        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            color: #000;
        }

        .icon-box {
            background-color: #002060;
            width: 40px;
            height: 40px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
        }

        /* Tabel */
        .table-card {
            border-radius: 10px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.05);
        }

        .table th {
            font-weight: 700;
            font-size: 0.9rem;
        }
        .table td {
            font-size: 0.9rem;
        }

        /* Pagination */
        .pagination .page-link {
            color: #333;
        }
        .pagination .active .page-link {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #333;
        }
    </style>
</head>

<body>

<div class="container py-4">
    <!-- TOP TABLE -->
    <h5 class="header-title mb-3">Daftar Pengajuan <span class="fw-bold">AKTIF</span></h5>

    @php $no = 1; @endphp

    <div class="card table-card p-4 bg-white mb-5">
        <!-- TABLE -->
        <div class="table-responsive">
            <table id="TableTop" class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Pengaju</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Surat</th>
                        <th>Sifat</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($surat as $item)
                @if ($item->status_surat > 0 && $item->status_surat < 6)
                    <tr onclick="window.location='{{ $item->sifat_surat == 'Dinas' ? url('/CRUD_Surat/surat-tugas/preview_pdf/' . $item->surat_id) : url('/CRUD_Surat/surat-tugas/detail/' . $item->surat_id) }}'" style="cursor:pointer">
                        <td>{{ $no++ }}</td>
                        <td class="fw-bold">{{ $item->jenis_tugas }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>
                        <td>{{ $item->sifat }}</td>

                        <td class="text-center">
                            @php
                                $badgeClass = [
                                    'diajukan' => 'warning text-dark',
                                    'diproses' => 'info text-dark',
                                    'disetujui_kaprodi' => 'primary',
                                    'disetujui_dekan' => 'primary',
                                    'ditandatangani' => 'success',
                                    'ditolak' => 'danger',
                                ][$item->status_surat] ?? 'secondary';
                            @endphp

                            <span class="badge bg-{{ $badgeClass }}">
                                {{ ucfirst(str_replace('_',' ',$item->status_surat)) }}
                            </span>
                        </td>
                    </tr>
                @endif
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada data surat tugas ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->

    </div>

    <!-- RIWAYAT -->
    <h5 class="header-title mb-3">Riwayat Pengajuan</h5>

    <div class="card table-card p-4 bg-white mb-5">
        <div class="table-responsive">
            @php $no = 1; @endphp
            <table id="TableBottom" class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Pengaju</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Surat</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width:10%">Aksi</th> <!-- 🔥 baru -->
                    </tr>
                </thead>

                <tbody>
                @forelse($surat as $item)
                @if ($item->status_surat == 0 || $item->status_surat == 6)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="fw-bold">{{ $item->jenis_tugas }}</td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>

                        <!-- STATUS -->
                        <td class="text-center">
                            @php
                                $statusLabel = [
                                    -1 => 'Dihapus',
                                    0  => 'Ditolak',
                                    1  => 'Diajukan',
                                    2  => 'Disetujui Kaprodi',
                                    3  => 'Disetujui Sekretaris',
                                    4  => 'Disetujui Dekan',
                                    5  => 'Menunggu Stempel',
                                    6  => 'Selesai',
                                ];
                        
                                $statusClass = [
                                    -1 => 'secondary',
                                    0  => 'danger',
                                    1  => 'warning text-dark',
                                    2  => 'info text-dark',
                                    3  => 'primary',
                                    4  => 'primary',
                                    5  => 'dark text-white',
                                    6  => 'success',
                                ];
                        
                                $label = $statusLabel[$item->status_surat] ?? 'Tidak Diketahui';
                                $class = $statusClass[$item->status_surat] ?? 'secondary';
                            @endphp

                            <span class="badge bg-{{ $class }}">{{ $label }}</span>
                        </td>

                        <!-- 🔥 AKSI PRINT PDF -->
                        <td class="text-center">
                            @if ($item->sifat == "Dinas")
                            <a onclick="window.location='{{ url('/CRUD_Surat/surat-tugas/preview_pdf/' . $item->surat_id) }}'" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                            @else
                            <a href="{{ route('surat-tugas.detail', $item->surat_id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                @endif
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada data surat tugas ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
@endsection
@push('scripts')

<script>
$(document).ready(function() {

    // ============================
    // TABEL ATAS (AKTIF)
    // ============================
    var tableTop = $('#TableTop').DataTable({
        pageLength: 10,
        searching: true,
    });

    $('#searchNameTop').on('keyup', function () {
        tableTop.column(1).search(this.value).draw();
    });


    // ============================
    // TABEL BAWAH (RIWAYAT)
    // ============================
    var tableBottom = $('#TableBottom').DataTable({
        pageLength: 10,
        searching: true,
    });

    $('#searchNameBottom').on('keyup', function () {
        tableBottom.column(1).search(this.value).draw();
    });

});
</script>

@endpush
