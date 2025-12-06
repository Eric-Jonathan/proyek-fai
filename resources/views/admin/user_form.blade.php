@extends('layouts.app')
@section('content')
<div class="container mt-4">

    <h3>{{ $user ? 'Edit User' : 'Tambah User Baru' }}</h3>

    <form action="{{ $user ? route('admin.users.update', $user->id) : route('admin.users.store') }}" 
          method="POST">
        @csrf

        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control"
               value="{{ old('full_name', $user->full_name ?? '') }}" required>
        @error('full_name') <small class="text-danger">{{ $message }}</small> @enderror

        <label>Username</label>
        <input type="text" name="username" class="form-control"
               value="{{ old('username', $user->username ?? '') }}" required>
        @error('username') <small class="text-danger">{{ $message }}</small> @enderror

        <label>Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $user->email ?? '') }}" required>
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror

        <label>NIDN</label>
        <input type="text" name="nidn" class="form-control"
               value="{{ old('nidn', $user->nidn ?? '') }}" required>
        @error('nidn') <small class="text-danger">{{ $message }}</small> @enderror

        <label>Lecturer Code</label>
        <input type="text" name="lecturer_code" class="form-control"
               value="{{ old('lecturer_code', $user->lecturer_code ?? '') }}">
        @error('lecturer_code') <small class="text-danger">{{ $message }}</small> @enderror

        <label>Password</label>
        <input type="password" name="password" class="form-control"
               {{ $user ? '' : 'required' }}>
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        @if($user)
            <small class="text-muted">Kosongkan jika tidak diganti</small>
        @endif
        <br>

        <label>Role</label>
        <select name="role" class="form-control">
            @foreach(['dosen','admin','sekretaris','kaprodi','dekan','rektor','bau'] as $r)
                <option value="{{ $r }}" 
                    {{ old('role', $user->role ?? '') == $r ? 'selected' : '' }}>
                    {{ ucfirst($r) }}
                </option>
            @endforeach
        </select>
        @error('role') <small class="text-danger">{{ $message }}</small> @enderror <br>

        <label>Status Kepegawaian</label>
        <select name="employment_status" class="form-control">
            @foreach(['active','inactive'] as $status)
                <option value="{{ $status }}"
                    {{ old('employment_status', $user->employment_status ?? '') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('employment_status') <small class="text-danger">{{ $message }}</small> @enderror

        <label>Certified?</label><br>
        <input type="checkbox" name="is_certified" value="1"
            {{ old('is_certified', $user->is_certified ?? 0) == 1 ? 'checked' : '' }}>
        Ya <br><br>
        @error('is_certified') <small class="text-danger">{{ $message }}</small> @enderror

        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control"
               value="{{ old('start_date', $user->start_date ?? '') }}">
        @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror

        <label>End Date</label>
        <input type="date" name="end_date" class="form-control"
               value="{{ old('end_date', $user->end_date ?? '') }}">
        @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror

        <hr>

        <h4>Permissions</h4>
        @php
            $userPermissions = $user ? $user->permissions->pluck('permission_id')->toArray() : [];
        @endphp

        @foreach($permissions as $p)
            <label>
                <input type="checkbox" name="permissions[]" value="{{ $p->permission_id }}"
                    {{ in_array($p->permission_id, $userPermissions) ? 'checked' : '' }}>
                {{ $p->permission_name }}
            </label><br>
        @endforeach

        <hr>

        <h4>Pilih Posisi (Hanya 1)</h4>
        @php
            $currentPos = $user->activePositionAssignment->position_id ?? null;
        @endphp
        <select name="position_id" class="form-control" required>
            @foreach($positions as $pos)
                <option value="{{ $pos->position_id }}"
                    {{ $currentPos == $pos->position_id ? 'selected' : '' }}>
                    {{ $pos->position_name }}
                </option>
            @endforeach
        </select>

        <hr>

        <button type="submit" class="btn btn-primary w-100">
            {{ $user ? 'Update User' : 'Create User' }}
        </button>
    </form>

</div>
@endsection
