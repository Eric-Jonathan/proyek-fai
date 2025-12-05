@extends('layouts.app')
@section('content')
<div class="container mt-4">

<h3>Tambah User Baru</h3>

<form action="{{ route('admin.users.store') }}" method="POST">
@csrf

<label>Full Name</label>
<input type="text" name="full_name" class="form-control" required>

<label>Username</label>
<input type="text" name="username" class="form-control" required>

<label>Email</label>
<input type="email" name="email" class="form-control" required>

<label>NIDN</label>
<input type="text" name="nidn" class="form-control" required>

<label>Lecturer Code</label>
<input type="text" name="lecturer_code" class="form-control">

<label>Password</label>
<input type="password" name="password" class="form-control" required>

<label>Role</label>
<select name="role" class="form-control">
    <option value="dosen">Dosen</option>
    <option value="admin">Admin</option>
    <option value="sekretaris">Sekretaris</option>
    <option value="kaprodi">Kaprodi</option>
    <option value="rektor">Rektor</option>
    <option value="bau">BAU</option>
</select>

<label>Status Kepegawaian</label>
<select name="employment_status" class="form-control">
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
</select>

<label>Certified?</label><br>
<input type="checkbox" name="is_certified" value="1"> Ya <br><br>

<label>Start Date</label>
<input type="date" name="start_date" class="form-control">

<label>End Date</label>
<input type="date" name="end_date" class="form-control">

<hr>

<h4>Permissions</h4>
@foreach($permissions as $p)
<label>
    <input type="checkbox" name="permissions[]" value="{{ $p->permission_id }}">
    {{ $p->permission_name }}
</label><br>
@endforeach

<hr>

<h4>Pilih Posisi (Hanya 1)</h4>
<select name="position_id" class="form-control" required>
    @foreach($positions as $pos)
        <option value="{{ $pos->position_id }}">{{ $pos->position_name }}</option>
    @endforeach
</select>

<hr>

<button type="submit" class="btn btn-primary w-100">Create User</button>
</form>

</div>
@endsection
