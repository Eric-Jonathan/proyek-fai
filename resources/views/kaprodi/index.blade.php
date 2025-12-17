@extends('layouts.app')

@section('title', 'Dashboard Surat Tugas')

@section('content')
<div class="container-fluid mt-4">

    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Dashboard Kaprodi</h4>
    </div>

    {{-- Statistik Surat --}}
    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-3 mb-4">    
        {{-- Card 1: Diajukan --}}
        <div class="col">
            <div class="card text-white bg-primary shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Diajukan</strong><br>{{ $stats['diajukan'] }} Surat
                    </div>
                    <i class="fa fa-paper-plane fa-2x"></i>
                </div>
            </div>
        </div>

        {{-- Card 2: Diproses --}}
        <div class="col">
            <div class="card text-white bg-warning shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Diproses</strong><br>{{ $stats['diproses'] }} Surat
                    </div>
                    <i class="fa fa-hourglass-half fa-2x"></i>
                </div>
            </div>
        </div>

        {{-- Card 3: Disetujui --}}
        <div class="col">
            <div class="card text-white bg-success shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Disetujui</strong><br>{{ $stats['disetujui'] }} Surat
                    </div>
                    <i class="fa fa-check-circle fa-2x"></i>
                </div>
            </div>
        </div>

        {{-- Card 4: Ditolak --}}
        <div class="col">
            <div class="card text-white bg-danger shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Ditolak</strong><br>{{ $stats['ditolak'] }} Surat
                    </div>
                    <i class="fa fa-times-circle fa-2x"></i>
                </div>
            </div>
        </div>

        {{-- Card 5: Perlu Tanda Tangan --}}
        <div class="col">
            <div class="card text-white bg-dark shadow h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Perlu TTD</strong><br>{{ $stats['perlu_ttd'] }} Surat
                    </div>
                    <i class="fa fa-pen-nib fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel ranking pemohon --}}
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-light">
        <h6 class="mb-0 fw-semibold">Top Pemohon (Diajukan)</h6>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Pemohon</th>
              <th>NIDN</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @foreach($perluTtdPemohon as $p)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->full_name ?? $p->nidn }}</td>
                <td>{{ $p->nidn }}</td>
                <td>{{ $p->total }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    
    {{-- Chart --}}
    <div class="card mb-4">
      <div class="card-body">
        <canvas id="chartPemohon" height="120"></canvas>
      </div>
    </div>
    
    {{-- Surat Perlu Tanda Tangan --}}
    @if(count($suratUntukTtd) > 0)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-semibold"><i class="fa fa-file-signature me-2"></i>Surat Menunggu Tanda Tangan</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Dosen</th>
                        <th>Jenis Tugas</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suratUntukTtd as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->full_name ?? '-' }}</td>
                        <td>{{ $p->jenis_tugas }}</td>
                        <td>{{ $p->tujuan }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('surat-tugas.preview', $p->surat_id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection


@section('custom_js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = {!! json_encode($perluTtdPemohon->pluck('full_name')) !!};
  const data   = {!! json_encode($perluTtdPemohon->pluck('total')) !!};

  new Chart(document.getElementById('chartPemohon'), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Jumlah Pengajuan (status = Diajukan)',
        data: data,
        borderWidth: 1
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, precision: 0 } }
    }
  });
</script>
@endsection
