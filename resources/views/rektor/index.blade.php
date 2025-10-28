@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="container-fluid mt-4">
    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Dashboard Surat Tugas</h4>
    </div>

    {{-- Statistik Surat --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-info card-blue">
                <div><strong>Diajukan</strong><br>12 Surat</div>
                <i class="fa fa-paper-plane fa-2x"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-info card-purple">
                <div><strong>Diproses</strong><br>8 Surat</div>
                <i class="fa fa-hourglass-half fa-2x"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-info card-purple">
                <div><strong>Disetujui</strong><br>25 Surat</div>
                <i class="fa fa-check-circle fa-2x"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-info card-blue">
                <div><strong>Ditolak</strong><br>3 Surat</div>
                <i class="fa fa-times-circle fa-2x"></i>
            </div>
        </div>
    </div>

    {{-- Daftar Surat Pengajuan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-semibold"><i class="fa fa-list me-2"></i>Daftar Pengajuan Surat Tugas</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-secondary">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama Dosen</th>
                        <th>Jenis Kegiatan</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dr. Alexander Erick</td>
                        <td>Surat Tugas</td>
                        <td>Seminar AI di ITS</td>
                        <td>10-11 Nov 2025</td>
                        <td><span class="badge bg-warning">Diproses</span></td>
                        <td class="text-center">
                            <button onclick="openDetailSurat({ nomor: 'ST/2025/001' })" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
                            <button onclick="openModalTolak()" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Johansen Kennedy</td>
                        <td>Assesor BKD</td>
                        <td>Evaluasi BKD FTI</td>
                        <td>3-4 Des 2025</td>
                        <td><span class="badge bg-success">Disetujui</span></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Riwayat Persetujuan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-semibold"><i class="fa fa-history me-2"></i>Riwayat Persetujuan & Keputusan</h6>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Kaprodi FTI</strong> menyetujui surat tugas "Seminar AI di ITS" pada <em>8 Nov 2025</em>.
                </li>
                <li class="list-group-item">
                    <strong>Dekan FST</strong> menandatangani surat tugas "Evaluasi BKD FTI" pada <em>4 Des 2025</em>.
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
@endsection
