<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kegiatan</title>

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

    <!-- HEADER -->
    <div class="d-flex align-items-center mb-4">
        <h3 class="header-title mb-0">Selamat Datang, [nama]</h3>
    </div>

    <!-- ACTION CARD -->
    <div class="row g-3 mb-5">
        <div class="col-md-6">
            <a href="#" class="card action-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3">
                            <i class="bi bi-bar-chart-line-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Ajukan Kegiatan</h5>
                            <small class="text-muted">Buat pengajuan kegiatan.</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right fs-4"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- TOP TABLE -->
    <h5 class="header-title mb-3">Daftar Pengajuan <span class="fw-bold">AKTIF</span></h5>

    <div class="card table-card p-4 bg-white mb-5">

        <!-- Filter + Search -->
        <form method="GET" action="{{ url()->current() }}">
            <div class="row mb-3 align-items-center">

                <div class="col-md-6 d-flex align-items-center">
                    <select name="per_page" class="form-select form-select-sm w-auto me-2" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <small class="text-muted">entitas per halaman</small>
                </div>

                <div class="col-md-6 d-flex justify-content-md-end align-items-center">
                    <label class="me-2 small text-muted">Search:</label>
                    <input type="search" name="search_top" value="{{ request('search_top') }}"
                           class="form-control form-control-sm w-auto" placeholder="Cari kegiatan..."
                           onblur="this.form.submit()">
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                </div>

            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
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
                @forelse($dataTop as $item)
                    <tr onclick="window.location='{{ url('/surat-tugas/preview/' . $item->surat_id) }}'" style="cursor:pointer">
                        <td>{{ $loop->iteration + $dataTop->firstItem() - 1 }}</td>
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
        <div class="row mt-2 align-items-center">
            <div class="col-md-6 small text-muted">
                Showing {{ $dataTop->firstItem() ?? 0 }} to {{ $dataTop->lastItem() ?? 0 }} of {{ $dataTop->total() }} entries
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    {{ $dataTop->appends([
                        'search_top' => request('search_top'),
                        'per_page' => request('per_page'),
                    ])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- RIWAYAT -->
    <h5 class="header-title mb-3">Riwayat Pengajuan</h5>

    <div class="card table-card p-4 bg-white">

        <!-- Filter -->
        <form method="GET" action="{{ url()->current() }}">
            <div class="row mb-3 align-items-center">

                <div class="col-md-6 d-flex align-items-center">
                    <select name="per_page_bottom" class="form-select form-select-sm w-auto me-2" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page_bottom') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page_bottom') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page_bottom') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                    <small class="text-muted">entitas per halaman</small>
                </div>

                <div class="col-md-6 d-flex justify-content-md-end">
                    <label class="me-2 small text-muted">Search:</label>
                    <input type="search" name="search_bottom" value="{{ request('search_bottom') }}"
                           class="form-control form-control-sm w-auto"
                           placeholder="Cari kegiatan..." onblur="this.form.submit()">
                </div>

            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Pengaju</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Surat</th>
                        <th>Sifat</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Print PDF</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($dataBottom as $item)
                    <tr onclick="window.location='{{ url('/surat-tugas/preview/' . $item->surat_id) }}'" style="cursor:pointer">
                        <td>{{ $loop->iteration + $dataBottom->firstItem() - 1 }}</td>
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

                        <td class="text-center">
                            @if($item->status_surat == 'ditandatangani')
                                <a href="#" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-file-earmark-pdf-fill"></i> Print
                                </a>
                            @else
                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                    <i class="bi bi-file-earmark-pdf"></i> Print
                                </button>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Tidak ada data surat tugas ditemukan.
                        </td>
                    </tr>

                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="row mt-2 align-items-center">
            <div class="col-md-6 small text-muted">
                Showing {{ $dataBottom->firstItem() ?? 0 }} to {{ $dataBottom->lastItem() ?? 0 }} of {{ $dataBottom->total() }} entries
            </div>

            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    {{ $dataBottom->appends([
                        'search_bottom' => request('search_bottom'),
                        'per_page_bottom' => request('per_page_bottom'),
                    ])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
