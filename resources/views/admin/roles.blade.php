@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary"><i class="fa fa-user-shield me-2"></i>Manajemen Role & Permission</h2>

    {{-- Form Tambah Role --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="fa fa-plus-circle me-2"></i> Tambah Role Baru
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                {{-- @csrf --}}
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <label class="form-label">Nama Role</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: sekretaris, dekan, admin">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Permission (pisahkan dengan koma)</label>
                        <input type="text" name="permissions" class="form-control" placeholder="Contoh: buat_surat, edit_user">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Daftar Role --}}
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <i class="fa fa-list me-2"></i>Daftar Role
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Role</th>
                        <th>Permission</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data statis (nanti diganti dari database) --}}
                    <tr>
                        <td>1</td>
                        <td><span class="badge bg-primary">admin</span></td>
                        <td>kelola_user, kelola_role, backup_data</td>
                        <td>
                            <button class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><span class="badge bg-info text-dark">sekretaris</span></td>
                        <td>buat_surat, lihat_laporan</td>
                        <td>
                            <button class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><span class="badge bg-success">dosen</span></td>
                        <td>lihat_surat, upload_dokumen</td>
                        <td>
                            <button class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
