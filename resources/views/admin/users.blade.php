@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid px-4 py-4">
    <h2 class="fw-bold mb-4">👥 Manajemen Akun Pengguna</h2>

    {{-- Tombol Tambah Akun --}}
    <div class="mb-3">
        <button class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Tambah Pengguna
        </button>
    </div>

    {{-- Tabel Daftar Pengguna --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold">
            <i class="fa fa-users me-2 text-secondary"></i>Daftar Pengguna Sistem
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data statis (nanti diganti dynamic dengan @foreach) --}}
                    <tr>
                        <td>1</td>
                        <td>Alexander Erick</td>
                        <td>erick@istts.ac.id</td>
                        <td><span class="badge bg-primary">Admin</span></td>
                        <td>20 Okt 2025</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning text-white me-1">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>heheh</td>
                        <td>heheh@istts.ac.id</td>
                        <td><span class="badge bg-success">Sekretaris</span></td>
                        <td>19 Okt 2025</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning text-white me-1">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Romi Santoso</td>
                        <td>romi@istts.ac.id</td>
                        <td><span class="badge bg-secondary">Kaprodi</span></td>
                        <td>17 Okt 2025</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning text-white me-1">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
