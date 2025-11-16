@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h3>{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h3>

    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        {{-- Username --}}
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control"
                   value="{{ old('username', $user->username ?? '') }}" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email', $user->email ?? '') }}" required>
        </div>

        {{-- NIDN --}}
        <div class="mb-3">
            <label for="nidn" class="form-label">NIDN</label>
            <input type="text" name="nidn" id="nidn" class="form-control"
                   value="{{ old('nidn', $user->nidn ?? '') }}" required>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control"
                   placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah' : '' }}">
        </div>

        {{-- Jabatan (gabungan role + jabatan) --}}
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <select name="jabatan" id="jabatan" class="form-select" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="admin" {{ old('jabatan', $user->jabatan ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="sekretaris" {{ old('jabatan', $user->jabatan ?? '') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                <option value="kaprodi" {{ old('jabatan', $user->jabatan ?? '') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                <option value="rektor" {{ old('jabatan', $user->jabatan ?? '') == 'rektor' ? 'selected' : '' }}>Rektor</option>
                <option value="bau" {{ old('jabatan', $user->jabatan ?? '') == 'bau' ? 'selected' : '' }}>BAU</option>
            </select>
        </div>

        {{-- Atasan (sementara fixed) --}}
        <div class="mb-3">
            <label for="atasan_id" class="form-label">Atasan</label>
            <select name="atasan_id" id="atasan_id" class="form-select">
                <option value="">-- Pilih Atasan --</option>
                <option value="1" {{ old('atasan_id', $user->atasan_id ?? '') == 1 ? 'selected' : '' }}>Admin Utama</option>
                <option value="2" {{ old('atasan_id', $user->atasan_id ?? '') == 2 ? 'selected' : '' }}>Rektor</option>
            </select>
        </div>

        {{-- ✅ Hak akses detail (muncul hanya saat edit user) --}}
        @if(isset($user))
        <div class="mb-3">
            <label class="form-label d-block">Hak Akses</label>
            @php
                $aksesList = [
                    'create surat' => 'Create Surat',
                    'lihat surat' => 'Lihat Surat',
                    'edit surat' => 'Edit Surat',
                    'acc surat' => 'ACC Surat',
                    'ttd surat' => 'TTD Surat',
                    'stempel surat' => 'Stempel Surat',
                ];
                $userAkses = $user->hak_akses_detail ?? [];
            @endphp

            @foreach ($aksesList as $value => $label)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="hak_akses_detail[]" 
                           value="{{ $value }}" 
                           id="akses_{{ $loop->index }}" 
                           {{ in_array($value, $userAkses ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label" for="akses_{{ $loop->index }}">{{ $label }}</label>
                </div>
            @endforeach

            <small class="text-muted">✅ Centang hak akses surat yang ingin diberikan.</small>
        </div>
        @endif

        <button type="submit" class="btn btn-primary">
            {{ isset($user) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
