@extends('layouts.app')

@section('title', 'Form Pengajuan Surat Tugas')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Pengajuan Surat Tugas</h5>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nomor Surat (readonly) --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" value="{{ $nomor_surat }}" readonly>
                </div>

                {{-- Nama Dosen (dari session) --}}
                <div class="mb-3">
                    <label class="form-label">Nama Dosen</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        value="{{ session('user.full_name') }}" 
                        readonly
                    >
                </div>

                {{-- NIDN (dari session) --}}
                <div class="mb-3">
                    <label class="form-label">NIDN</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        value="{{ session('user.nidn') }}" 
                        readonly
                    >
                </div>

                {{-- Jabatan --}}
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Contoh: Dosen S1-Informatika, Kaprodi S1-Desain Komunikasi Visual">
                </div>

                {{-- Jenis Surat --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Tugas</label>
                    <textarea name="jenis_tugas" class="form-control" rows="3" required></textarea>
                </div>

                {{-- Dasar Tugas --}}
                <div class="mb-3">
                    <label class="form-label">Dasar Tugas</label>
                    <textarea name="dasar_tugas" class="form-control" rows="3" required></textarea>
                </div>

                {{-- Sifat --}}
                <div class="mb-3">
                    <label class="form-label">Sifat</label>
                    <select name="sifat_surat" class="form-select" required>
                        <option value="Dinas">Dinas</option>
                        <option value="Non-Dinas">Non-Dinas</option>                    
                    </select>
                </div>

                {{-- Tujuan --}}
                <div class="mb-3">
                    <label class="form-label">Tujuan</label>
                    <input type="text" class="form-control" name="tujuan" required>
                </div>

                {{-- Waktu Pelaksanaan --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>
                </div>

                {{-- Lampiran --}}
                <div class="mb-3">
                    <label class="form-label">Lampiran Surat Masuk / Undangan</label>
                    <input type="file" name="lampiran" class="form-control" required>
                </div>

                {{-- Tanggal Surat --}}
                {{-- <div class="mb-3">
                    <label class="form-label">Tanggal Surat Dibuat</label>
                    <input type="text" class="form-control" value="{{ now()->format('d-m-Y') }}" readonly>
                </div> --}}

                <div class="text-end">
                    <button class="btn btn-primary">Ajukan Surat Tugas</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
