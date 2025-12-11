@extends('layouts.app')

@section('title', 'Dashboard Surat Tugas')

@section('content')
<div class="container-fluid mt-4">
    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Dashboard Surat Tugas</h4>
    </div>

    <div class="row g-3 mb-4">    
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
    </div>

    {{-- Daftar Surat Pengajuan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-semibold">Daftar Pengajuan Surat Tugas</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle pt-3" id="tablePengajuan">
                <thead class="table-secondary">
                    <tr class="text-center">
                        <th>Jenis Tugas</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surat as $s)
                        @if ($s->status_surat>0 && $s->status_surat<6)
                            <tr>
                                <td>{{ $s->jenis_tugas }}</td>
                                <td>{{ $s->tujuan }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->tanggal_mulai)->translatedFormat('d F Y') }}</td>

                                <td class="text-center">
                                    @php
                                        $statusBadge = [
                                            -1 => ['secondary', 'Dihapus'],
                                             0 => ['danger', 'Ditolak'],
                                             1 => ['warning text-dark', 'Diajukan'],
                                             2 => ['info text-dark', 'Disetujui Kaprodi'],
                                             3 => ['primary', 'Diproses Sekretaris'],
                                             4 => ['primary', 'Disetujui Dekan'],
                                             5 => ['dark text-white', 'Menunggu Stempel'],
                                             6 => ['success', 'Selesai'],
                                        ];
                                    @endphp

                                    @if(isset($statusBadge[$s->status_surat]))
                                        <span class="badge bg-{{ $statusBadge[$s->status_surat][0] }}">
                                            {{ $statusBadge[$s->status_surat][1] }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($s->status_surat >= 0 && $s->status_surat < 2)
                                        <a href="{{ route('surat-tugas.detail', $s->surat_id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    
                                        <a href="{{ route('CRUD_Surat.edit', $s->surat_id) }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @elseif ($s->status_surat >= 0 )
                                        <a href="{{ route('surat-tugas.detail', $s->surat_id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('surat-tugas.detail', $s->surat_id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-semibold">Riwayat Pengajuan Surat Tugas</h6>
        </div>
        <div class="card-body">
            <table id="tableRiwayat" class="table table-bordered align-middle pt-3">
                <thead class="table-secondary">
                    <tr class="text-center">
                        <th>Jenis Tugas</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surat as $s)
                        @if ($s->status_surat==0 || $s->status_surat==6)
                            <tr >
                                <td>{{ $s->jenis_tugas }}</td>
                                <td>{{ $s->tujuan }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->tanggal_mulai)->translatedFormat('d F Y') }}</td>

                                <td class="text-center">
                                    @if($s->status_surat == 0)
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-success">Telah Ditandatangani</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('surat-tugas.detail', $s->surat_id) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Detail Surat -->
<div class="modal fade" id="modalDetailSurat" tabindex="-1" aria-labelledby="modalDetailSuratLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalDetailSuratLabel">Detail Surat Tugas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tr>
            <th>Nomor Surat</th>
            <td>ST/2025/034</td>
          </tr>
          <tr>
            <th>Nama Dosen</th>
            <td>Dr. Alexander Erick</td>
          </tr>
          <tr>
            <th>Kegiatan</th>
            <td>Seminar AI di ITS</td>
          </tr>
          <tr>
            <th>Tanggal</th>
            <td>5 - 7 November 2025</td>
          </tr>
          <tr>
            <th>Status</th>
            <td><span class="badge bg-warning">Diproses</span></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal tolak surat --}}
<div class="modal" id="modalTolakSurat" tabindex="-1" aria-labelledby="modalDetailSuratLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alasan Penolakan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Berikan alasan mengapa menolak pengajuan surat</p>
        <input type="text" name="" class="form-control" placeholder="ex : Ada acara besar kampus">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-danger">Tolak</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('custom_js')
    <script>
        $(document).ready(function() {
            var table = $('#tablePengajuan').DataTable({
                pageLength: 10,
                searching: true,
            });
            var table = $('#tableRiwayat').DataTable({
                pageLength: 10,
                searching: true,
            });

            // 🔥 Search khusus FULLNAME (kolom index 1)
            // $('#searchName').on('keyup', function () {
            //     table.column(1).search(this.value).draw();
            // });
        });
    </script>
@endsection