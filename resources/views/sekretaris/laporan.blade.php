@extends('layouts.app')

@section('title', 'Laporan Surat Tugas')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4"><i class="fa fa-chart-line me-2"></i> Laporan Surat Tugas</h3>

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
                        @for ($year = 2022; $year <= 2025; $year++)
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
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h6 class="text-muted">Total Surat</h6>
                    <h4 class="text-primary fw-bold">42</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h6 class="text-muted">Disetujui</h6>
                    <h4 class="text-success fw-bold">28</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Menunggu ACC</h6>
                    <h4 class="text-warning fw-bold">10</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <h6 class="text-muted">Ditolak</h6>
                    <h4 class="text-danger fw-bold">4</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- 📋 Tabel Data Laporan -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nomor Surat</th>
                        <th>Nama Dosen</th>
                        <th>Judul Surat</th>
                        <th>Tanggal Diajukan</th>
                        <th>Status</th>
                        <th>Tanggal ACC</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data sementara --}}
                    <tr>
                        <td>1</td>
                        <td>ST/FTI/2025/012</td>
                        <td>Dr. Maria Santoso</td>
                        <td>Kunjungan Industri ke PT Telkom</td>
                        <td>10 Oktober 2025</td>
                        <td><span class="badge bg-success">Disetujui</span></td>
                        <td>15 Oktober 2025</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>ST/FTI/2025/015</td>
                        <td>Ir. Budi Hartono</td>
                        <td>Pelatihan Mahasiswa di ITS</td>
                        <td>12 Oktober 2025</td>
                        <td><span class="badge bg-warning text-dark">Menunggu ACC</span></td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>

            <!-- 📄 Tombol Cetak -->
            <div class="text-end mt-3">
                <button class="btn btn-success"><i class="fa fa-print me-2"></i>Cetak Laporan</button>
            </div>
        </div>
    </div>
</div>
@endsection
