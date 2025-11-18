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
            
            <div class="row mb-3 align-items-center">
                <div class="col-md-6 d-flex align-items-center">
                    <select class="form-select form-select-sm w-auto me-2">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <small class="text-muted">entitas per halaman</small>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end align-items-center mt-2 mt-md-0">
                    <label class="me-2 small text-muted">Search:</label>
                    <input type="search" class="form-control form-control-sm w-auto" placeholder="Cari...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">ID <i class="bi bi-caret-up-fill small text-primary"></i></th>
                            <th scope="col">Nama Kegiatan <i class="bi bi-arrow-down-up small text-muted opacity-25"></i></th>
                            <th scope="col">Tanggal <i class="bi bi-arrow-down-up small text-muted opacity-25"></i></th>
                            <th scope="col">Penyelenggara <i class="bi bi-arrow-down-up small text-muted opacity-25"></i></th>
                            <th scope="col">Jabatan <i class="bi bi-arrow-down-up small text-muted opacity-25"></i></th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>OPEN TALK SIB 2025</td>
                            <td>26 May 2025</td>
                            <td>HIMA SIB 2024/2025</td>
                            <td>KETUA</td>
                            <td><button type="button" class="btn btn-secondary">Belum</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>OPEN TALK SIB 2025</td>
                            <td>26 May 2025</td>
                            <td>HIMA SIB 2024/2025</td>
                            <td>KETUA</td>
                            <td><button type="button" class="btn btn-success">Diterima</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row align-items-center mt-2">
    <div class="col-md-6 small text-muted">
        Showing 1 to 2 of 2 entries
    </div>
    
    <div class="col-md-6">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
        </div>

        <br><br>
        <h5 class="header-title mb-3">Riwayat Pengajuan </h5>
        <div class="card table-card p-4 bg-white">
            
            <div class="row mb-3 align-items-center">
                <div class="col-md-6 d-flex align-items-center">
                    <select class="form-select form-select-sm w-auto me-2">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <small class="text-muted">entitas per halaman</small>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end align-items-center mt-2 mt-md-0">
                    <label class="me-2 small text-muted">Search:</label>
                    <input type="search" class="form-control form-control-sm w-auto" placeholder="Cari...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">ID <i class="bi bi-caret-up-fill small text-primary"></i></th>
                            <th scope="col">Nama Kegiatan <i class="bi bi-arrow-down-up small text-muted opacity-25"></i></th>
                            <th scope="col">Tanggal <i class="bi bi-arrow-down-up small text-muted opacity-25"></i></th>
                            <th scope="col">Penyelenggara <i class="bi bi-arrow-down-up small text-muted opacity-25"></i></th>
                            <th scope="col">Jabatan <i class="bi bi-arrow-down-up small text-muted opacity-25"></i></th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>OPEN TALK SIB 2025</td>
                            <td>26 May 2025</td>
                            <td>HIMA SIB 2024/2025</td>
                            <td>KETUA</td>
                            <td><button type="button" class="btn btn-secondary">Belum</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>OPEN TALK SIB 2025</td>
                            <td>26 May 2025</td>
                            <td>HIMA SIB 2024/2025</td>
                            <td>KETUA</td>
                            <td><button type="button" class="btn btn-success">Diterima</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row align-items-center mt-2">
    <div class="col-md-6 small text-muted">
        Showing 1 to 2 of 2 entries
    </div>
    
    <div class="col-md-6">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>