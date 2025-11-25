@extends('layouts.app')

@section('title', 'Form Pengajuan Surat Tugas')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Pengajuan Surat Tugas</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('surat-tugas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nomor Surat (auto generate, readonly) --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" value="{{ $nomor_surat }}" readonly>
                </div>

                {{-- Nama Dosen (autofill) --}}
                <div class="mb-3">
                    <label class="form-label">Nama Dosen</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                </div>

                {{-- NIDN (autofill) --}}
                <div class="mb-3">
                    <label class="form-label">NIDN</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->nidn }}" readonly>
                </div>

                {{-- Jabatan --}}
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <select name="position_id" class="form-select" required>
                        <option disabled selected>Pilih Jabatan</option>
                        @foreach ($positions as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Surat Tugas --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Surat Tugas</label>
                    <select name="jenis_surat" class="form-select" required>
                        <option disabled selected>Pilih Jenis Surat</option>
                        <option value="Dinas">Dinas</option>
                        <option value="Kegiatan Akademik">Kegiatan Akademik</option>
                        <option value="Kegiatan Non-Akademik">Kegiatan Non-Akademik</option>
                    </select>
                </div>

                {{-- Dasar Tugas --}}
                <div class="mb-3">
                    <label class="form-label">Dasar Tugas</label>
                    <textarea name="dasar_tugas" class="form-control" rows="3" required></textarea>
                </div>

                {{-- Sifat --}}
                <div class="mb-3">
                    <label class="form-label">Sifat</label>
                    <select name="sifat" class="form-select" required>
                        <option value="Penting">Penting</option>
                        <option value="Segera">Segera</option>
                        <option value="Rahasia">Rahasia</option>
                    </select>
                </div>

                {{-- Tujuan --}}
                <div class="mb-3">
                    <label class="form-label">Tujuan</label>
                    <input type="text" class="form-control" name="tujuan" placeholder="Tujuan surat" required>
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

                {{-- Tanggal Surat Dibuat --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Surat Dibuat</label>
                    <input type="text" class="form-control" value="{{ now()->format('d-m-Y') }}" readonly>
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Ajukan Surat Tugas</button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
