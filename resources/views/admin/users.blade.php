@stack('scripts')
@extends('layouts.app')
@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Daftar User</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">+ Tambah User</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <table id="usersTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>NIDN</th>
                <th>Fullname</th>
                <th>Position</th>
                <th>Email</th>
                <th>Employee Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Permission</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u->nidn }}</td>
                    <td>{{ $u->full_name }}</td>
                    <td>{{ $u->activePositionAssignment->position->position_name ?? '-' }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->employment_status ?? '-' }}</td>
                    <td>{{ $u->positionAssignment->start_date ?? '-' }}</td>
                    <td>{{ $u->positionAssignment->end_date ?? '-' }}</td>
                    <td>    
                        @if($u->permissions->count())
                            {{ $u->permissions->pluck('permission_name')->join(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        var table = $('#usersTable').DataTable({
            pageLength: 10,
            searching: true,
        });

        // 🔥 Search khusus FULLNAME (kolom index 1)
        $('#searchName').on('keyup', function () {
            table.column(1).search(this.value).draw();
        });
    });
</script>
@endpush

