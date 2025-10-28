@extends('layouts.app')

@section('title', 'Surat Tugas BAU')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold mb-3"><i class="fa fa-file-alt me-2"></i>Daftar Surat Tugas</h4>

    <div class="card shadow-sm table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Nomor Surat</th>
                    <th>Dosen</th>
                    <th>Fakultas</th>
                    <th>Status Stempel</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr onclick="window.location='{{ route('bau.surat_detail', 1) }}'" style="cursor: pointer;">
                    <td>1</td>
                    <td>ST/2025/001</td>
                    <td>Dr. Alexander Erick</td>
                    <td>FTI</td>
                    <td><span class="badge bg-warning text-dark">Belum Distempel</span></td>
                    <td>
                        <button class="btn btn-sm btn-success">Validasi & Stempel</button>
                        <button class="btn btn-sm btn-primary">Upload ke Arsip</button>
                    </td>
                </tr>
                <tr onclick="window.location='{{ route('bau.surat_detail', 2) }}'" style="cursor: pointer;">
                    <td>2</td>
                    <td>ST/2025/002</td>
                    <td>Johansen Kennedy</td>
                    <td>FTI</td>
                    <td><span class="badge bg-success">Sudah Distempel</span></td>
                    <td>
                        <button class="btn btn-sm btn-success">Validasi & Stempel</button>
                        <button class="btn btn-sm btn-primary">Upload ke Arsip</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
