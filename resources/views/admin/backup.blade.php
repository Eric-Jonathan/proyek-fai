@extends('layouts.app')

@section('title', 'Backup & Reset Nomor Surat')

@section('content')
<div class="container-fluid px-4 py-4">
    <h2 class="fw-bold mb-4"><i class="fa fa-database me-2"></i>Backup & Reset Nomor Surat</h2>

    {{-- 📦 Bagian Backup Database --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="fa fa-hdd me-2"></i> Backup Data Sistem
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">
                Backup digunakan untuk menyimpan salinan data sistem seperti surat tugas, surat keluar, pengguna, dan log aktivitas.  
                File backup akan disimpan dalam format <code>.zip</code> di server atau Google Drive.
            </p>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="fa fa-download me-1"></i> Buat Backup Baru
                </button>
                <button class="btn btn-success">
                    <i class="fa fa-upload me-1"></i> Restore Backup
                </button>
            </div>

            {{-- Daftar Backup --}}
            <div class="table-responsive mt-4">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama File</th>
                            <th>Tanggal Backup</th>
                            <th>Ukuran</th>
                            <th>Lokasi Penyimpanan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Contoh data dummy --}}
                        <tr>
                            <td class="text-center">1</td>
                            <td>backup_2025-10-27.zip</td>
                            <td>27 Oktober 2025, 21:35</td>
                            <td>52 MB</td>
                            <td>Server Lokal</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success me-1">
                                    <i class="fa fa-download"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>backup_2025-09-30.zip</td>
                            <td>30 September 2025, 10:18</td>
                            <td>48 MB</td>
                            <td>Google Drive</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success me-1">
                                    <i class="fa fa-download"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-info mt-3">
                <i class="fa fa-info-circle me-2"></i>
                Backup otomatis dilakukan setiap minggu pada hari <strong>Jumat pukul 23:00</strong>.
            </div>
        </div>
    </div>

    {{-- 🔄 Bagian Reset Nomor Surat --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark fw-bold">
            <i class="fa fa-sync-alt me-2"></i> Reset Nomor Surat Tahunan
        </div>
        <div class="card-body">
            <p class="text-muted">
                Sistem penomoran surat mengikuti format <code>Nomor: XXX/ISTTS/A6/MM/YYYY</code>  
                di mana bagian <strong>XXX</strong> akan direset menjadi <strong>001</strong> setiap awal tahun (bulan Januari).  
                Kamu juga bisa melakukan reset manual di sini jika diperlukan.
            </p>

            <div class="d-flex gap-2">
                <button class="btn btn-warning text-white">
                    <i class="fa fa-sync-alt me-1"></i> Reset Sekarang
                </button>
                <button class="btn btn-secondary">
                    <i class="fa fa-clock me-1"></i> Jadwalkan Otomatis
                </button>
            </div>

            {{-- Contoh Preview Nomor --}}
            <div class="mt-4">
                <h6 class="fw-bold">📄 Contoh Format Nomor Surat</h6>
                <div class="border p-3 bg-light rounded">
                    <p class="mb-1">
                        <strong>Sebelum Reset:</strong> 157/ISTTS/A6/X/2025  
                        <br>
                        <strong>Setelah Reset:</strong> 001/ISTTS/A6/I/2026
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
