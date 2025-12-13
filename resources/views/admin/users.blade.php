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
                <th>Full Name</th>
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
                        <a href="{{ route('admin.users.delete', $u->id) }}" class="btn btn-danger btn-sm ">Hapus</a>    
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection

@push('scripts')

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

