<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Surat Penugasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #2f3542;
            color: #fff;
        }
        .sidebar .profile {
            text-align: center;
            padding: 30px 10px;
            border-bottom: 1px solid #444;
        }
        .sidebar .profile img {
            width: 90px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .sidebar .menu a {
            display: block;
            padding: 10px 20px;
            color: #dcdde1;
            text-decoration: none;
            transition: 0.2s;
        }
        .sidebar .menu a.logout {
            color: #ff7675; /* Warna teks merah muda */
            border-top: 1px solid #57606f;
            margin-top: 10px;
        }
        .sidebar .menu a:hover, .sidebar .menu a.active {
            background-color: #57606f;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

    </style>
    @yield('custom_css')
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="profile">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User">
            <h5>Hi, {{ ucfirst(session('user.username')) }}!</h5>
            <small>{{ session('user.jabatan') ?? '--'}}</small>
        </div>

        @php
            $role = session('user')['role'] ?? null;
            $permissions = session('user')['permissions'] ?? [];
        @endphp

        <div class="menu">
            @if($role === 'admin')
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.users') }}">Manajemen User</a>
                <a href="{{ route('admin.surat') }}">Manajemen Surat</a>
                {{-- <a href="{{ route('admin.templates') }}">Manajemen Template Surat</a> --}}
                {{-- <a href="{{ route('admin.roles') }}">Manajemen Role</a> --}}
                <a href="{{ route('admin.logs') }}">Log Aktivitas</a>
                {{-- <a href="{{ route('admin.backup') }}">Backup</a> --}}
                <a href="{{ route('logout') }}" class="logout">Logout</a>
            @elseif($role === 'bau')
                <a href="{{ route($role . '.dashboard') }}">Dashboard</a>

                @if(in_array('create_surat', $permissions))
                    <a href="{{ route('CRUD_Surat.form_surat') }}">Buat Surat</a>
                @endif
                
                

                <a href="{{ route('logout') }}" class="logout" >Logout</a>

            @elseif($role === 'kaprodi')
                <a href="{{ route($role . '.dashboard') }}">Dashboard</a>

                @if(in_array('create_surat', $permissions))
                    <a href="{{ route('kaprodi.CRUD_Surat.form_surat') }}">Buat Surat</a>
                @endif

                @if(in_array('lihat_surat', $permissions))
                    <a href="{{ route('kaprodi.riwayatSurat') }}">Riwayat Surat</a>
                @endif

                <a href="{{ route('logout') }}"  class="logout" >Logout</a>
            
            @elseif($role === 'dekan')
                <a href="{{ route($role . '.dashboard') }}">Dashboard</a>

                @if(in_array('create_surat', $permissions))
                    <a href="{{ route('dekan.CRUD_Surat.form_surat') }}">Buat Surat</a>
                @endif

                @if(in_array('lihat_surat', $permissions))
                    <a href="{{ route('dekan.riwayatSurat') }}">Riwayat Surat</a>
                @endif

                <a href="{{ route('logout') }}"  class="logout" >Logout</a>

            @elseif($role === 'rektor')
                <a href="{{ route($role . '.dashboard') }}">Dashboard</a>

                @if(in_array('lihat_surat', $permissions))
                    <a href="{{ route('rektor.listPengajuan') }}">List Pengajuan Surat</a>
                @endif

                {{-- Bagian @if(in_array('lihat_surat', $permissions)) kosong sehingga saya hapus agar lebih rapi --}}

                <a href="{{ route('logout') }}"  class="logout" >Logout</a>

            @elseif($role === 'dosen')
                <a href="{{ route($role . '.dashboard') }}">Dashboard</a>

                @if(in_array('create_surat', $permissions))
                    <a href="{{ route('CRUD_Surat.form_surat') }}">Buat Surat</a>
                @endif

                @if(in_array('lihat_surat', $permissions))
                    <a href="{{ route('dosen.riwayatSurat') }}">Riwayat Surat</a>
                @endif

                <a href="{{ route('logout') }}" class="logout" >Logout</a>
            
            {{-- Bagian @else telah disederhanakan dan dipindahkan ke dalam conditional yang sesuai --}}
            {{-- Jika ada peran lain yang belum terdefinisi (seperti 'pegawai' atau 'user' generik),
                 Anda bisa mengaktifkan kembali blok @else dengan menu default: --}}
            
            @else
                <a href="{{ route($role . '.dashboard') }}">Dashboard</a>
                <a href="{{ route('logout') }}" class="logout" >Logout</a>
            
            @endif
        </div>
    </div>

    

    {{-- Content (INI HARUS DI ATAS SCRIPT) --}}
    <div class="content">
        @yield('content')
    </div>
    
    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    {{-- CUSTOM JS --}}
    @yield('custom_js')

    @stack('scripts')

</body>
</html>