@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="fa fa-plus-square me-2"></i>Buat Surat Tugas</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form>
                {{-- Pilihan Jenis Surat --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Jenis Surat Tugas</label>
                    <select class="form-select" required>
                        <option value="" selected disabled>Pilih Jenis Surat</option>
                        <option value="tugas">Surat Tugas Umum</option>
                        <option value="assesor">Surat Tugas Assesor BKD</option>
                    </select>
                </div>

                {{-- Data Dosen --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Dosen</label>
                    <input type="text" class="form-control" placeholder="Masukkan nama dosen" required>
                </div>

                {{-- NIDN --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">NIDN</label>
                    <input type="text" class="form-control" placeholder="Masukkan NIDN dosen" required>
                </div>

                {{-- Jabatan dan Prodi --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jabatan</label>
                        <input type="text" class="form-control" placeholder="Contoh: Dosen Tetap" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Program Studi</label>
                        <input type="text" class="form-control" placeholder="Contoh: Teknik Informatika" required>
                    </div>
                </div>

                {{-- Nama Kegiatan --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kegiatan</label>
                    <input type="text" class="form-control" placeholder="Contoh: Seminar Nasional Teknologi Informasi" required>
                </div>

                {{-- Tempat dan Tanggal --}}
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Tempat Kegiatan</label>
                        <input type="text" class="form-control" placeholder="Masukkan lokasi kegiatan" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" required>
                    </div>
                </div>

                {{-- Tujuan Penugasan --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tujuan Penugasan</label>
                    <textarea class="form-control" rows="3" placeholder="Jelaskan tujuan dari penugasan ini" required></textarea>
                </div>

                {{-- File Pendukung --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Upload File Pendukung (Opsional)</label>
                    <input type="file" class="form-control">
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="fa fa-undo me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-1"></i>Simpan & Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
