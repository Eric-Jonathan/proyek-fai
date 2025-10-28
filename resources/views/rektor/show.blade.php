@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0"><i class="fa fa-file-text me-2"></i>Detail Surat Tugas</h4>
        <a href="{{ route('rektor.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card Surat --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Nomor Surat:</strong> ST/2025/001</p>
                    <p class="mb-1"><strong>Nama Dosen:</strong> Dr. Alexander Erick</p>
                    <p class="mb-1"><strong>Jenis Kegiatan:</strong> Seminar AI</p>
                    <p class="mb-1"><strong>Tujuan:</strong> ITS Surabaya</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tanggal:</strong> 10–11 November 2025</p>
                    <p class="mb-1">
                        <strong>Status:</strong>
                        <span class="badge bg-warning text-dark">Diproses</span>
                    </p>
                </div>
            </div>

            <hr>

            {{-- Isi Surat --}}
            <p class="fw-semibold mb-2">Menugaskan kepada:</p>
            <ul class="mb-3">
                <li><b>Dr. Alexander Erick</b> – Dosen Teknik Informatika</li>
            </ul>
            <p class="mb-4">
                Untuk menghadiri <b>Seminar Kecerdasan Buatan</b> yang diselenggarakan di 
                <b>Institut Teknologi Sepuluh Nopember (ITS)</b> pada tanggal 
                <b>10–11 November 2025</b>.
            </p>

            {{-- Tombol Aksi --}}
            <div class="d-flex gap-2">
                <button class="btn btn-success" id="btnAcc">
                    <i class="fa fa-check me-1"></i> Setujui
                </button>
                <button class="btn btn-danger" onclick="openModalTolak()">
                    <i class="fa fa-times me-1"></i> Tolak
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Penolakan --}}
<div class="modal fade" id="modalTolakSurat" tabindex="-1" aria-labelledby="modalTolakSuratLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-semibold"><i class="fa fa-comment me-2 text-danger"></i>Alasan Penolakan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted mb-2">Berikan alasan mengapa menolak pengajuan surat:</p>
        <input type="text" id="alasanPenolakan" class="form-control" placeholder="Contoh: Ada acara besar kampus">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-danger" id="btnTolakFinal">Tolak</button>
      </div>
    </div>
  </div>
</div>

{{-- Script --}}
<script>
    function openModalTolak() {
        const modal = new bootstrap.Modal(document.getElementById('modalTolakSurat'));
        modal.show();
    }

    document.getElementById('btnAcc').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menyetujui surat ini?')) {
            alert('✅ Surat berhasil disetujui.');
            // TODO: ganti alert dengan fetch ke backend untuk update status surat
        }
    });

    document.getElementById('btnTolakFinal').addEventListener('click', function() {
        const alasan = document.getElementById('alasanPenolakan').value;
        if (!alasan.trim()) {
            alert('⚠️ Harap isi alasan penolakan!');
            return;
        }
        alert('❌ Surat ditolak dengan alasan: ' + alasan);
        const modalEl = document.getElementById('modalTolakSurat');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
        // TODO: kirim data penolakan ke backend
    });
</script>
@endsection
