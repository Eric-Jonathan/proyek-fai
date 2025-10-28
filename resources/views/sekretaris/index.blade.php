@extends('layouts.app')

@section('title', 'Dashboard Sekretaris')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4"><i class="fa fa-home me-2"></i> Dashboard Sekretaris</h3>

    <!-- 🗓️ Filter -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <select class="form-select" name="bulan">
                        <option value="">Semua Bulan</option>
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <select class="form-select" name="tahun">
                        <option value="">Semua Tahun</option>
                        @for ($year = 2023; $year <= 2025; $year++)
                            <option>{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option>Menunggu ACC</option>
                        <option>Disetujui</option>
                        <option>Ditolak</option>
                        <option>Selesai</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex justify-content-end">
                    <button class="btn btn-primary"><i class="fa fa-search me-2"></i>Tampilkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 📊 Statistik Ringkas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Surat</h6>
                    <h4 class="text-primary fw-bold">42</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-success shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Disetujui</h6>
                    <h4 class="text-success fw-bold">28</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-warning shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Menunggu ACC</h6>
                    <h4 class="text-warning fw-bold">10</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-danger shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Ditolak</h6>
                    <h4 class="text-danger fw-bold">4</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel daftar surat tugas --}}
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Judul Surat</th>
                    <th>Dosen Pengaju</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contoh data dummy untuk tampilan awal --}}
                <tr>
                    <td>1</td>
                    <td>Surat Tugas Seminar Nasional AI</td>
                    <td>Dr. Andi Santoso</td>
                    <td>2025-10-10</td>
                    <td>2025-10-12</td>
                    <td><span class="badge bg-success">Disetujui Dekan</span></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i> Periksa
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Surat Tugas Workshop IoT di Malang</td>
                    <td>Ir. Budi Prakoso</td>
                    <td>2025-09-05</td>
                    <td>2025-09-07</td>
                    <td><span class="badge bg-info text-dark">Diperiksa Sekretaris</span></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-secondary">
                            <i class="fa fa-eye"></i> Lihat
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Surat Tugas Rapat Kerjasama</td>
                    <td>Prof. Maria Dewi</td>
                    <td>2025-10-20</td>
                    <td>2025-10-21</td>
                    <td><span class="badge bg-warning text-dark">Menunggu Stampel BAU</span></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i> Periksa
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- 🕓 Aktivitas Terbaru -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <strong><i class="fa fa-clock me-2"></i>Aktivitas Terbaru</strong>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="fa fa-file-alt text-primary me-2"></i>
                        Surat Tugas “Kunjungan Industri ke PT Telkom” telah disetujui oleh Dekan.
                        <small class="text-muted float-end">15 Okt 2025</small>
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-user-edit text-warning me-2"></i>
                        Dosen “Ir. Budi Hartono” mengajukan revisi surat tugas.
                        <small class="text-muted float-end">14 Okt 2025</small>
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-paper-plane text-success me-2"></i>
                        Surat keluar “Balasan Undangan LLDIKTI” berhasil dikirim.
                        <small class="text-muted float-end">13 Okt 2025</small>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 📄 Tombol Cetak -->
        <div class="text-end mt-3">
            <button class="btn btn-success"><i class="fa fa-print me-2"></i>Cetak Laporan</button>
        </div>
    </div>
    </div>
</div>
@endsection
