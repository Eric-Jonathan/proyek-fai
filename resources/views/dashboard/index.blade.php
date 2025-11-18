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
            background-color: #f4f6f9; /* Warna background abu-abu muda */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Styling Header Text */
        .header-title {
            color: #002060; /* Warna biru tua seperti di logo */
            font-weight: 700;
        }

        /* Styling Kartu Kuning/Orange */
        .action-card {
            background: #ffc107; /* Base yellow */
            background: linear-gradient(90deg, #ffc107 0%, #ffca2c 100%);
            border: none;
            border-radius: 8px;
            transition: transform 0.2s;
            cursor: pointer;
            text-decoration: none; /* Hilangkan garis bawah link */
            color: #000;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            color: #000;
        }

        .icon-box {
            background-color: #002060;
            color: white;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            font-size: 1.2rem;
        }

        /* Styling Tabel agar mirip DataTables */
        .table-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .table th {
            font-size: 0.9rem;
            font-weight: 700;
            border-bottom: 2px solid #dee2e6;
        }
        
        .table td {
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .step-badge {
            background-color: #c00; /* Merah tua */
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }

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
        
        <div class="d-flex align-items-center mb-4">
            <h3 class="header-title mb-0">Selamat Datang, [nama]</h3>
        </div>

        <div class="row g-3 mb-5">
            <div class="col-md-6">
                <a href="#" class="card action-card p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3">
                                <i class="bi bi-bar-chart-line-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Ajukan Kegiatan</h5>
                                <small class="text-muted" style="color: #333 !important;">Buat pengajuan kegiatan.</small>
                            </div>
                        </div>
                        <div class="fs-4">
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            {{-- <div class="col-md-6">
                <a href="#" class="card action-card p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3">
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Ajukan Organisasi</h5>
                                <small class="text-muted" style="color: #333 !important;">Buat laporan pengajuan organisasi.</small>
                            </div>
                        </div>
                        <div class="fs-4">
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>

        <h5 class="header-title mb-3">Daftar Pengajuan <span class="fw-bold">AKTIF</span></h5>

        <div class="card table-card p-4 bg-white">
            <!-- Form Pencarian & Pagination -->
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
                    <div class="col-md-6 d-flex justify-content-md-end align-items-center mt-2 mt-md-0">
                        <label class="me-2 small text-muted">Search:</label>
                        <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm w-auto" placeholder="Cari Kegiatan..." onblur="this.form.submit()">
                    </div>
                </div>
            </form>
        
            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 5%;">No</th>
                            <th scope="col">Nama Kegiatan</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Tempat Kegiatan</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <!-- 1. No -->
                            <td>{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                        
                            <!-- 2. Nama Kegiatan -->
                            <td class="fw-bold">{{ $item->nama_kegiatan }}</td>
                        
                            <!-- 3. Tanggal Mulai -->
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                        
                            <!-- 4. Tanggal Selesai -->
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                        
                            <!-- 5. Tempat Kegiatan -->
                            <td>{{ $item->tempat_kegiatan }}</td>
                        
                            <!-- 6. Status -->
                            <td class="text-center">
                                @php
                                    $badgeClass = 'secondary';
                                    $label = ucfirst(str_replace('_', ' ', $item->status_surat));
                            
                                    switch($item->status_surat) {
                                        case 'diajukan':
                                            $badgeClass = 'warning text-dark'; 
                                            break;
                                        case 'diproses':
                                            $badgeClass = 'info text-dark'; 
                                            break;
                                        case 'disetujui_kaprodi':
                                        case 'disetujui_dekan':
                                            $badgeClass = 'primary'; 
                                            break;
                                        case 'ditandatangani':
                                            $badgeClass = 'success'; 
                                            break;
                                        case 'ditolak':
                                            $badgeClass = 'danger'; 
                                            break;
                                    }
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $label }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada data surat tugas ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        
            <!-- Footer Pagination -->
            <div class="row align-items-center mt-2">
                <div class="col-md-6 small text-muted">
                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }} entries
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <div class="d-flex justify-content-end">
                            {{ $data->links('pagination::bootstrap-5') }}
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <br><br>

        <h5 class="header-title mb-3">Riwayat Pengajuan </h5>
        <div class="card table-card p-4 bg-white">
            <!-- Form Pencarian & Pagination -->
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
                    <div class="col-md-6 d-flex justify-content-md-end align-items-center mt-2 mt-md-0">
                        <label class="me-2 small text-muted">Search:</label>
                        <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm w-auto" placeholder="Cari Kegiatan..." onblur="this.form.submit()">
                    </div>
                </div>
            </form>
        
            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No Surat</th>
                            <th scope="col">Nama Kegiatan</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col">Tempat Kegiatan</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Print PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <!-- 1. No Surat (Menampilkan placeholder jika belum ada nomor) -->
                            <td class="text-nowrap">
                                @if($item->nomor_surat_final)
                                    <span class="fw-bold text-dark">{{ $item->nomor_surat_final }}</span>
                                @else
                                    <span class="text-muted small fst-italic">- Belum Terbit -</span>
                                @endif
                            </td>
                        
                            <!-- 2. Nama Kegiatan -->
                            <td class="fw-bold">{{ $item->nama_kegiatan }}</td>
                        
                            <!-- 3. Tanggal Mulai -->
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                        
                            <!-- 4. Tanggal Selesai -->
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                        
                            <!-- 5. Tempat Kegiatan -->
                            <td>{{ $item->tempat_kegiatan }}</td>
                        
                            <!-- 6. Status -->
                            <td class="text-center">
                                @php
                                    $badgeClass = 'secondary';
                                    $label = ucfirst(str_replace('_', ' ', $item->status_surat));
                            
                                    switch($item->status_surat) {
                                        case 'diajukan':
                                            $badgeClass = 'warning text-dark'; 
                                            break;
                                        case 'diproses':
                                            $badgeClass = 'info text-dark'; 
                                            break;
                                        case 'disetujui_kaprodi':
                                        case 'disetujui_dekan':
                                            $badgeClass = 'primary'; 
                                            break;
                                        case 'ditandatangani':
                                            $badgeClass = 'success'; 
                                            break;
                                        case 'ditolak':
                                            $badgeClass = 'danger'; 
                                            break;
                                    }
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $label }}</span>
                            </td>
                        
                            <!-- 7. Print PDF -->
                            <td class="text-center">
                                <!-- Tombol hanya aktif jika status sudah ditandatangani (opsional logic) -->
                                @if($item->status_surat == 'ditandatangani')
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Cetak Surat">
                                        <i class="bi bi-file-earmark-pdf-fill"></i> Print
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Surat belum selesai">
                                        <i class="bi bi-file-earmark-pdf"></i> Print
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Tidak ada data surat tugas ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        
            <!-- Footer Pagination -->
            <div class="row align-items-center mt-2">
                <div class="col-md-6 small text-muted">
                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }} entries
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <div class="d-flex justify-content-end">
                            {{ $data->links('pagination::bootstrap-5') }}
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>