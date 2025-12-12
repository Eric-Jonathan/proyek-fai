@extends('layouts.app')

@section('title', 'Form Pengajuan Surat Tugas')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Pengajuan Surat Tugas</h5>
        </div>

        <div class="card-body">
            @php
            // dd(session('user'))
            @endphp

            <form action="{{ route('CRUD_Surat.submit_surat') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nomor Surat --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" value="{{ $nomor_surat }}" readonly>
                </div>

                {{-- Nama Dosen --}}
                <div class="mb-3">
                    <label class="form-label">Nama Dosen</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        value="{{ session('user.full_name') }}" 
                        readonly
                    >
                </div>

                {{-- NIDN --}}
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
                    <input type="text" class="form-control"
                    value="{{ $jabatan ?? 'Tidak ada jabatan aktif' }}" readonly>
                </div>

                {{-- Jenis Tugas --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Tugas</label>
                    <textarea 
                        name="jenis_tugas" 
                        class="form-control" 
                        rows="3" 
                        required>{{ old('jenis_tugas') }}</textarea>
                    @error('jenis_tugas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Dasar Tugas --}}
                <div class="mb-3">
                    <label class="form-label">Dasar Tugas</label>
                    <textarea 
                        name="dasar_tugas" 
                        class="form-control" 
                        rows="3" 
                        required>{{ old('dasar_tugas') }}</textarea>
                    @error('dasar_tugas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Sifat --}}
                <div class="mb-3">
                    <label class="form-label">Sifat</label>
                    <select name="sifat_surat" class="form-select" required>
                        <option value="Dinas" {{ old('sifat_surat') == 'Dinas' ? 'selected' : '' }}>Dinas</option>
                        <option value="Non-Dinas" {{ old('sifat_surat') == 'Non-Dinas' ? 'selected' : '' }}>Non-Dinas</option>
                    </select>
                    @error('sifat_surat') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Tujuan --}}
                <div class="mb-3">
                    <label class="form-label">Tujuan</label>
                    <input 
                        type="text" 
                        name="tujuan" 
                        class="form-control" 
                        value="{{ old('tujuan') }}" 
                        required>
                    @error('tujuan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Waktu Pelaksanaan --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input 
                            type="date" 
                            name="tanggal_mulai" 
                            class="form-control"
                            value="{{ old('tanggal_mulai') }}"
                            required>
                        @error('tanggal_mulai') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input 
                            type="date" 
                            name="tanggal_selesai" 
                            class="form-control"
                            value="{{ old('tanggal_selesai') }}"
                            required>
                        @error('tanggal_selesai') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Lampiran --}}
                <div class="mb-3">
                    <label class="form-label">Lampiran Surat Masuk / Undangan</label>
                    <input 
                        type="file" 
                        name="lampiran" 
                        class="form-control"
                        required>
                    @error('lampiran') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button class="btn btn-primary">Ajukan Surat Tugas</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
