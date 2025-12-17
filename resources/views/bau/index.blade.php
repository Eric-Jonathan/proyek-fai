@extends('layouts.app')

@section('title', 'Dashboard Sekretaris')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4"><i class="fa fa-home me-2"></i> Dashboard BAU</h3>

    <!-- 🔍 Filter -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="" method="GET" class="row g-3 align-items-end">
                
                <!-- Bulan -->
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <select class="form-select" name="bulan">
                        <option value="">Semua Bulan</option>
                        @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                            <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                                {{ $b }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun -->
                <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <select class="form-select" name="tahun">
                        <option value="">Semua Tahun</option>
                        @for ($year = 2023; $year <= 2025; $year++)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Status -->
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        @foreach (['Diajukan', 'Disetujui Kaprodi', 'Diproses', 'Disetujui Dekan', 'Ditandatangani', 'Ditolak'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex justify-content-end">
                    <button class="btn btn-primary"><i class="fa fa-search me-2"></i>Tampilkan</button>
                    <a href="{{ route('sekretaris.dashboard') }}" class="btn btn-secondary ms-2"><i class="fas fa-sync-alt"></i> Reset </a>
                </div>            
            </form>
        </div>
    </div>

    <!-- 📊 Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Surat</h6>
                    <h4 class="fw-bold text-primary">{{ $stats['total'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-success shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Disetujui</h6>
                    <h4 class="fw-bold text-success">{{ $stats['disetujui'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-warning shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Diproses</h6>
                    <h4 class="fw-bold text-warning">{{ $stats['diproses'] }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-danger shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Ditolak</h6>
                    <h4 class="fw-bold text-danger">{{ $stats['ditolak'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- 📄 Tabel Data -->
    {{-- <div class="card shadow-sm">
        <div class="card-header bg-light fw-semibold">
            Daftar Surat Tugas
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Judul Surat</th>
                        <th>Dosen Pengaju</th>
                        <th>Tanggal Surat</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($surat as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->dasar_tugas ?? '-' }}</td>
                        <td>{{ $item->full_name ?? '-' }}</td>
                        <td>{{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->format('Y-m-d') : '-' }}</td>
                        <td>{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y-m-d') : '-' }}</td>
                        <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('Y-m-d') : '-' }}</td>
                    
                        <!-- Status Badge -->
                        <td>
                            @php
                                $statusLabel = [
                                    -1 => 'Dihapus',
                                    0  => 'Ditolak',
                                    1  => 'Diajukan',
                                    2  => 'Disetujui Kaprodi',
                                    3  => 'Disetujui Sekretaris',
                                    4  => 'Disetujui Dekan',
                                    5  => 'Menunggu Stempel',
                                    6  => 'Selesai',
                                ];
                        
                                $statusClass = [
                                    -1 => 'secondary',
                                    0  => 'danger',
                                    1  => 'warning text-dark',
                                    2  => 'info text-dark',
                                    3  => 'primary',
                                    4  => 'primary',
                                    5  => 'dark text-white',
                                    6  => 'success',
                                ];
                        
                                $label = $statusLabel[$item->status_surat] ?? 'Tidak Diketahui';
                                $class = $statusClass[$item->status_surat] ?? 'secondary';
                            @endphp
                        
                            <span class="badge bg-{{ $class }}">
                                {{ $label }}
                            </span>
                        </td>
                        <!-- Tombol -->
                        <td>
                            @if ($item->status_surat >= 0 && $item->status_surat < 2)
                                <a href="{{ route('surat-tugas.detail', $item->surat_id) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            
                                <a href="{{ route('CRUD_Surat.edit', $item->surat_id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @elseif ($item->status_surat >= 0 )
                                <a href="{{ route('surat-tugas.detail', $item->surat_id) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @else
                                <a href="{{ route('surat-tugas.detail', $item->surat_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fa fa-folder-open fa-2x mb-2"></i><br>
                            Tidak ada data surat ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div> --}}
    <h5 class="header-title mb-3">Daftar Surat Tugas</h5>

    @php $no = 1; @endphp

    <div class="card table-card p-4 bg-white mb-5">
        <!-- TABLE -->
        <div class="table-responsive">
            <table id="TableTop" class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Judul Surat</th>
                        <th>Dosen Pengaju</th>
                        <th>Tanggal Surat</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th style="width:160px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($surat as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->jenis_tugas ?? '-' }}</td>
                        <td>{{ $item->full_name ?? '-' }}</td>
                        <td>{{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->format('Y-m-d') : '-' }}</td>
                        <td>{{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y-m-d') : '-' }}</td>
                        <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('Y-m-d') : '-' }}</td>
                    
                        <!-- Status Badge -->
                        <td>
                            @php
                                $statusLabel = [
                                    -1 => 'Dihapus',
                                    0  => 'Ditolak',
                                    1  => 'Diajukan',
                                    2  => 'Disetujui Kaprodi',
                                    3  => 'Disetujui Sekretaris',
                                    4  => 'Disetujui Dekan',
                                    5  => 'Menunggu Stempel',
                                    6  => 'Selesai',
                                ];
                        
                                $statusClass = [
                                    -1 => 'secondary',
                                    0  => 'danger',
                                    1  => 'warning text-dark',
                                    2  => 'info text-dark',
                                    3  => 'primary',
                                    4  => 'primary',
                                    5  => 'dark text-white',
                                    6  => 'success',
                                ];
                        
                                $label = $statusLabel[$item->status_surat] ?? 'Tidak Diketahui';
                                $class = $statusClass[$item->status_surat] ?? 'secondary';
                            @endphp
                        
                            <span class="badge bg-{{ $class }}">
                                {{ $label }}
                            </span>
                        </td>
                        <!-- Tombol -->
                        <td>
                            @if ($item->status_surat >= 0 && $item->status_surat < 2)
                                <a href="{{ route('surat.preview_pdf', $item->surat_id) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            
                                <a href="{{ route('CRUD_Surat.edit', $item->surat_id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @elseif ($item->status_surat >= 0 )
                                <a href="{{ route('surat-tugas.preview', $item->surat_id) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @else
                                <a href="{{ route('surat-tugas.detail', $item->surat_id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-download"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Tidak ada data surat tugas ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
$(document).ready(function() {

    // ============================
    // TABEL ATAS (AKTIF)
    // ============================
    var tableTop = $('#TableTop').DataTable({
        pageLength: 10,
        searching: true,
    });

    $('#searchNameTop').on('keyup', function () {
        tableTop.column(1).search(this.value).draw();
    });


    // ============================
    // TABEL BAWAH (RIWAYAT)
    // ============================
    var tableBottom = $('#TableBottom').DataTable({
        pageLength: 10,
        searching: true,
    });

    $('#searchNameBottom').on('keyup', function () {
        tableBottom.column(1).search(this.value).draw();
    });

});
</script>

@endpush
