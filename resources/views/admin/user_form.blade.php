@extends('layouts.app')
@section('content')
<div class="container mt-4">
    @if($errors->any())
        @dump($errors->all())
    @endif
    <h3>{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h3>
    <form action="{{ route('admin.users.store') }}" method="POST">
@csrf

{{-- Username --}}
<label>Username</label>
<input type="text" name="username" class="form-control">

{{-- Email --}}
<label>Email</label>
<input type="email" name="email" class="form-control">

{{-- NIDN --}}
<label>NIDN</label>
<input type="text" name="nidn" class="form-control">

{{-- Role --}}
<label>Role</label>
<select name="role" class="form-control">
    <option value="dosen">Dosen</option>
    <option value="admin">Admin</option>
    <option value="sekretaris">Sekretaris</option>
    <option value="kaprodi">Kaprodi</option>
    <option value="rektor">Rektor</option>
    <option value="bau">BAU</option>
</select>

{{-- Password --}}
<label>Password</label>
<input type="password" name="password" class="form-control">

<hr>

{{-- Permissions --}}
<h4>Permissions</h4>
@foreach($permissions as $p)
    <label>
        <input type="checkbox" name="permissions[]" value="{{ $p->permission_id }}">
        {{ $p->name }}
    </label><br>
@endforeach

<hr>

{{-- Position Assignment --}}
<h4>Position Assignments</h4>

<div id="positions-wrapper">
    <div class="position-group mb-3">
        <label>Position</label>
        <select name="positions[0][position_id]" class="form-control">
            @foreach($positions as $pos)
                <option value="{{ $pos->position_id }}">{{ $pos->position_name }}</option>
            @endforeach
        </select>

        <label>Start Date</label>
        <input type="date" name="positions[0][start_date]" class="form-control">

        <label>End Date</label>
        <input type="date" name="positions[0][end_date]" class="form-control">
    </div>
</div>

<button type="button" onclick="addPosition()" class="btn btn-secondary">+ Tambah Jabatan</button>

<hr>

<button type="submit" class="btn btn-primary">Create User</button>
</form>

<script>
let posIndex = 1;
function addPosition() {
    const wrap = document.getElementById('positions-wrapper');
    wrap.insertAdjacentHTML('beforeend', `
        <div class="position-group mb-3">
            <label>Position</label>
            <select name="positions[${posIndex}][position_id]" class="form-control">
                @foreach($positions as $pos)
                    <option value="{{ $pos->position_id }}">{{ $pos->position_name }}</option>
                @endforeach
            </select>

            <label>Start Date</label>
            <input type="date" name="positions[${posIndex}][start_date]" class="form-control">

            <label>End Date</label>
            <input type="date" name="positions[${posIndex}][end_date]" class="form-control">
        </div>
    `);
    posIndex++;
}
</script>

</div>
@endsection