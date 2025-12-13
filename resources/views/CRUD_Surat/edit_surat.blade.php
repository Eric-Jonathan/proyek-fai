@extends('layouts.app')

@section('title', 'Revisi Surat Tugas')

@section('content')

<div class="container">
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5 class="mb-0">Edit Surat Tugas</h5>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('CRUD_Surat.update', $surat->surat_id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nomor Surat --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" value="{{ $surat->nomor_surat }}" readonly>
                </div>

                {{-- Nama Dosen --}}
                <div class="mb-3">
                    <label class="form-label">Nama Dosen</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        value="{{ $surat->lecturer->full_name ?? '-' }}" 
                        readonly>
                </div>


                {{-- NIDN --}}
                <div class="mb-3">
                    <label class="form-label">NIDN</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        value="{{ $surat->nidn }}" 
                        readonly>
                </div>

                {{-- Jabatan --}}
                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input 
                        type="text"
                        class="form-control"
                        value="{{ session('user.jabatan') ?? 'Tidak ada jabatan aktif' }}"
                        readonly
                    >
                </div>

                {{-- Jenis Tugas --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Tugas</label>
                    <textarea 
                        name="jenis_tugas" 
                        class="form-control" 
                        rows="3" 
                        required>{{ old('jenis_tugas', $surat->jenis_tugas) }}</textarea>
                    @error('jenis_tugas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Dasar Tugas --}}
                <div class="mb-3">
                    <label class="form-label">Dasar Tugas</label>
                    <textarea 
                        name="dasar_tugas" 
                        class="form-control" 
                        rows="3"
                        required>{{ old('dasar_tugas', $surat->dasar_tugas) }}</textarea>
                    @error('dasar_tugas') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Sifat Surat --}}
                <div class="mb-3">
                    <label class="form-label">Sifat Surat</label>
                    <select name="sifat_surat" class="form-select" required>
                        <option value="Dinas" {{ $surat->sifat_surat == 'Dinas' ? 'selected' : '' }}>Dinas</option>
                        <option value="Non-Dinas" {{ $surat->sifat_surat == 'Non-Dinas' ? 'selected' : '' }}>Non-Dinas</option>
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
                        value="{{ old('tujuan', $surat->tujuan) }}" 
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
                            value="{{ old('tanggal_mulai', optional($surat->tanggal_mulai)->format('Y-m-d')) }}"
                            required>
                        @error('tanggal_mulai') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input 
                            type="date" 
                            name="tanggal_selesai" 
                            class="form-control"
                            value="{{ old('tanggal_selesai', optional($surat->tanggal_selesai)->format('Y-m-d')) }}"
                            required>
                        @error('tanggal_selesai') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- Lampiran --}}
                <div class="mb-3">
                    <label class="form-label">Lampiran Surat Masuk / Undangan</label>
                    <input type="file" name="lampiran" class="form-control">
                    
                    @if($surat->lampiran_path)
                        <small class="text-muted d-block mt-1">
                            File sekarang:
                            <a href="{{ asset('storage/' . $surat->lampiran_path) }}" target="_blank">
                                {{ basename($surat->lampiran_path) }}
                            </a>
                        </small>
                    @endif

                    @error('lampiran') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Tombol --}}
                <div class="text-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection