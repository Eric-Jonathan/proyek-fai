@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="container-fluid px-4 py-4">
    <h2 class="fw-bold mb-4"><i class="fa fa-history me-2"></i>Log Aktivitas Sistem</h2>

    

    {{-- 🔍 Filter Pencarian --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="#" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pengguna</label>
                    <input type="text" name="user" class="form-control" placeholder="Nama pengguna...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jenis Aktivitas</label>
                    <select class="form-select" name="jenis">
                        <option value="">Semua</option>
                        <option value="aju">Mengajukan Surat</option>
                        <option value="update">Mengubah Surat</option>
                        <option value="nolak">Menolak Surat</option>
                        <option value="buat">Membuat User</option>
                        <option value="baru">Update User</option>
                        <option value="hapus">Menghapus User</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.logs') }}" class="btn btn-secondary ms-2"><i class="fas fa-sync-alt"></i> Reset </a>
                </div>
            </form>
        </div>
    </div>

    {{-- 📈 Statistik Singkat --}}
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Aktivitas Hari Ini</h6>
                    <h4 class="fw-bold text-primary">{{ $today }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-success shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Aktivitas Berhasil</h6>
                    <h4 class="fw-bold text-success">{{ $total }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-danger shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Aktivitas Gagal</h6>
                    <h4 class="fw-bold text-danger">0</h4>
                </div>
            </div>
        </div>
    </div>
    <br>

    {{-- 📋 Tabel Log Aktivitas --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold">
            <i class="fa fa-list-alt me-2 text-secondary"></i>Daftar Aktivitas Terbaru
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <div class="mt-3 px-3">
    {{ $logs->links() }}
</div>
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">#</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aktivitas</th>
                        <th>Keterangan</th>
                        <th width="10%">Status</th>
                    </tr>
                </thead>
                <tbody>
    @forelse ($logs as $index => $log)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>

            {{-- Tanggal --}}
            <td>{{ $log->created_at?->format('d M Y') }}</td>

            {{-- Waktu --}}
            <td>{{ $log->created_at?->format('H:i') }}</td>

            {{-- Pengguna --}}
            <td>
                <i class="fa fa-user text-primary me-1"></i>
                {{ $log->lecturer->username ?? $log->nidn }}
            </td>

            {{-- Aktivitas --}}
            <td>{{ $log->aktivitas }}</td>

            {{-- Keterangan --}}
            <td>{{ $log->keterangan }}</td>

            {{-- Status --}}
            <td class="text-center">
                @php
                    $status = 'success';
                    if (str_contains(strtolower($log->aktivitas), 'gagal')) $status = 'danger';
                    elseif (str_contains(strtolower($log->aktivitas), 'hapus')) $status = 'warning';
                @endphp

                <span class="badge bg-{{ $status }}">
                    {{ ucfirst($status) }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-3 text-muted">
                Tidak ada aktivitas.
            </td>
        </tr>
    @endforelse
</tbody>

            </table>
        </div>
        
    </div>

    
</div>
@endsection
