@extends('layouts.app')

@section('title', 'Arsip Surat Tugas')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4"><i class="fa fa-archive me-2"></i> Arsip Surat Tugas</h3>

    <!-- 🔍 Pencarian -->
    <div class="mb-3">
        <form action="" method="GET" class="d-flex" role="search">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari berdasarkan nama dosen atau judul surat...">
            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <!-- 📋 Tabel Arsip Surat -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nomor Surat</th>
                        <th>Nama Dosen</th>
                        <th>Judul Surat</th>
                        <th>Tanggal Diterbitkan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data statis sementara --}}
                    <tr>
                        <td>1</td>
                        <td>ST/FTI/2025/012</td>
                        <td>Dr. Maria Santoso</td>
                        <td>Kunjungan Industri ke PT Telkom</td>
                        <td>15 Oktober 2025</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                            <a href="#" class="btn btn-sm btn-success"><i class="fa fa-download"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>ST/FTI/2025/013</td>
                        <td>Ir. Budi Hartono</td>
                        <td>Pelatihan Mahasiswa di ITS</td>
                        <td>20 Oktober 2025</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                            <a href="#" class="btn btn-sm btn-success"><i class="fa fa-download"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- 📄 Pagination (sementara dummy) -->
            <nav>
                <ul class="pagination justify-content-end">
                    <li class="page-item disabled"><a class="page-link">«</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
