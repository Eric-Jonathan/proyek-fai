@extends('layouts.app')

@section('title', 'Dashboard Admin Sistem')

@section('content')
<div class="container-fluid px-4 py-4">
    <h2 class="fw-bold mb-4">Dashboard Admin Sistem</h2>

    {{-- Statistik Singkat --}}
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center py-4">
                    <i class="fa fa-users fa-2x text-primary mb-3"></i>
                    <h4 class="fw-bold mb-1">{{ $stats['user'] }}</h4>
                    <small class="text-muted">Total Akun Pengguna</small>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center py-4">
                    <i class="fa fa-key fa-2x text-success mb-3"></i>
                    <h4 class="fw-bold mb-1">{{ $stats['permission'] }}</h4>
                    <small class="text-muted">Total Role & Permission</small>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center py-4">
                    <i class="fa fa-file-alt fa-2x text-warning mb-3"></i>
                    <h4 class="fw-bold mb-1">{{ $stats['surat_template'] }}</h4>
                    <small class="text-muted">Template Surat Aktif</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Log Aktivitas Terbaru --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white fw-bold">
            <i class="fa fa-history me-2 text-secondary"></i>Log Aktivitas Terbaru
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $a)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($a->created_at)->format('Y-m-d')}}</td>
                        <td><i class="fa fa-user text-primary me-1"></i> {{ $a->full_name }}</td>
                        <td>{{ $a->aktivitas }}</td>
                        <td>{{ $a->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
