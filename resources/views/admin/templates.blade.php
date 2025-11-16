@extends('layouts.app')

@section('title', 'Template Surat')

@section('content')
<div class="container-fluid px-4 py-4">
    <h2 class="fw-bold mb-4"><i class="fa fa-file-alt me-2"></i> Manajemen Template Surat</h2>

    {{-- Tombol Tambah Template
    <div class="mb-3">
        <button class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Tambah Template Baru
        </button>
    </div> --}}

    {{-- Daftar Template Surat --}}
    <div class="row g-4">
        {{-- Template 1: Surat Tugas Biasa --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-2">
                        <i class="fa fa-briefcase me-2"></i>Surat Tugas Biasa
                    </h5>
                    <p class="small text-muted mb-3">
                        Template untuk dosen yang menjadi narasumber, pembicara, atau peserta kegiatan resmi (contoh: Visiting Professor).
                    </p>
                    <div class="border rounded bg-light p-2 mb-3" style="height: 140px; overflow-y: auto;">
                        <strong>Contoh:</strong><br>
                        <em>Nomor: 923/A6/ISTTS/X/2025</em><br>
                        <strong>Nama:</strong> Prof. Dr. Ir. Esther Irawati Setiawan, S.Kom., M.Kom.<br>
                        <strong>Jenis tugas:</strong> Visiting Professor - Building LLM Applications with Prompt Engineer<br>
                        <strong>Tujuan:</strong> KMUTT, Thailand<br>
                        <strong>Tanggal:</strong> 31 Oktober 2025
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-sm btn-secondary">
                            <i class="fa fa-eye me-1"></i> Pratinjau
                        </button>
                        <button class="btn btn-sm btn-warning text-white">
                            <i class="fa fa-edit me-1"></i> Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Catatan Tambahan --}}
    <div class="alert alert-info mt-4">
        <i class="fa fa-info-circle me-2"></i>
        Template di atas dapat diedit dan disimpan sebagai file Blade (<code>resources/views/templates/*.blade.php</code>)
        untuk digunakan otomatis oleh sistem saat Sekretaris membuat surat tugas atau surat keluar.
    </div>
</div>
@endsection
