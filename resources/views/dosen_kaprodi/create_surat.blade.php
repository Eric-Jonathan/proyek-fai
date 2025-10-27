@extends('layouts.app')

@section('title', 'Ajukan Surat Tugas')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Pengajuan Surat Tugas</h5>
        </div>

        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Jenis Kegiatan --}}
                <div class="mb-3">
                    <label for="jenis_kegiatan" class="form-label fw-semibold">Jenis Kegiatan</label>
                    <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-select">
                        <option value="">-- Pilih Jenis Kegiatan --</option>
                        <option value="Surat Tugas">Surat Tugas Biasa</option>
                        <option value="Assesor BKD">Assesor BKD</option>
                    </select>
                </div>

                {{-- Tujuan --}}
                <div class="mb-3">
                    <label for="tujuan" class="form-label fw-semibold">Tujuan Kegiatan</label>
                    <input type="text" name="tujuan" id="tujuan" class="form-control" placeholder="Contoh: Seminar Nasional AI di ITS">
                </div>

                {{-- Tempat --}}
                <div class="mb-3">
                    <label for="tempat" class="form-label fw-semibold">Tempat</label>
                    <input type="text" name="tempat" id="tempat" class="form-control" placeholder="Lokasi kegiatan">
                </div>

                {{-- Tanggal --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
                    </div>
                </div>

                {{-- Lampiran Surat Undangan --}}
                <div class="mb-3">
                    <label for="lampiran" class="form-label fw-semibold">Lampiran Surat Undangan</label>
                    <input type="file" name="lampiran" id="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Format: PDF atau Gambar (max 2MB)</small>
                </div>

                {{-- Permintaan Transport --}}
                <div class="mb-3">
                    <label for="transport" class="form-label fw-semibold">Apakah membutuhkan transportasi kampus?</label>
                    <select name="transport" id="transport" class="form-select">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="text-end">
                    <a href="{{ route('kaprodi.dashboard') }}" class="btn btn-secondary me-2">Batal</a>
                    <button class="btn btn-primary">
                        <i class="bi bi-send-fill me-1"></i> Ajukan Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection