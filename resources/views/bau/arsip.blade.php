@extends('layouts.app')

@section('title', 'Arsip Surat BAU')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold mb-3"><i class="fa fa-archive me-2"></i>Arsip Surat Tugas</h4>

    <div class="card shadow-sm table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr >
                    <th>#</th>
                    <th>Nomor Surat</th>
                    <th>Dosen</th>
                    <th>Fakultas</th>
                    <th>Status Arsip</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr onclick="window.location='{{ route('bau.surat_detail', 1) }}'" style="cursor: pointer;">
                    <td>1</td>
                    <td>ST/2025/001</td>
                    <td>Dr. Alexander Erick</td>
                    <td>FTI</td>
                    <td><span class="badge bg-success">Tersimpan</span></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                        <a href="#" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
