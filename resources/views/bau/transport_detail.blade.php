@extends('layouts.app')

@section('title', 'Detail Kendaraan BAU')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0"><i class="fa fa-truck me-2"></i>Detail Kendaraan</h4>
        <a href="{{ route('bau.transport') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card Kendaraan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Nama Kendaraan:</strong> Avanza 2022</p>
                    <p class="mb-1"><strong>Nomor Polisi:</strong> B 1234 XYZ</p>
                    <p class="mb-1"><strong>Sopir:</strong> Budi Santoso</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Jadwal Penggunaan:</strong> 10 November 2025</p>
                    <p class="mb-1">
                        <strong>Status:</strong>
                        <span class="badge bg-success">Tersedia</span>
                    </p>
                    <p class="mb-1"><strong>Kapasitas Penumpang:</strong> 6 orang</p>
                </div>
            </div>

            <hr>

            {{-- Aksi Kendaraan --}}
            <div class="d-flex gap-2">
                <button class="btn btn-success" id="btnUpdateStatus">
                    <i class="fa fa-check me-1"></i> Update Status
                </button>
                <button class="btn btn-primary" id="btnEdit">
                    <i class="fa fa-edit me-1"></i> Edit Info
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
document.getElementById('btnUpdateStatus').addEventListener('click', function() {
    if(confirm('Apakah Anda ingin mengubah status kendaraan ini?')) {
        alert('✅ Status kendaraan berhasil diperbarui.');
        // TODO: update status kendaraan ke backend
    }
});

document.getElementById('btnEdit').addEventListener('click', function() {
    alert('📝 Halaman edit info kendaraan (fitur backend belum aktif).');
    // TODO: redirect ke halaman edit kendaraan
});
</script>
@endsection
