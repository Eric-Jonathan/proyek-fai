@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="fa fa-paper-plane me-2"></i>Surat Keluar / Balasan</h4>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Buat Surat Keluar Baru</h5>

            <form>
                {{-- Nomor Surat --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nomor Surat</label>
                    <input type="text" class="form-control" placeholder="Nomor surat akan terisi otomatis" disabled>
                </div>

                {{-- Tanggal Surat --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Surat</label>
                    <input type="date" class="form-control" required>
                </div>

                {{-- Tujuan Surat --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tujuan Surat</label>
                    <input type="text" class="form-control" placeholder="Nama instansi / penerima surat" required>
                </div>

                {{-- Perihal --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Perihal</label>
                    <input type="text" class="form-control" placeholder="Contoh: Balasan undangan seminar nasional" required>
                </div>

                {{-- Isi Surat --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Surat</label>
                    <textarea class="form-control" rows="5" placeholder="Tulis isi surat balasan di sini..." required></textarea>
                </div>

                {{-- Lampiran --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Upload Lampiran (Opsional)</label>
                    <input type="file" class="form-control">
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="fa fa-undo me-1"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-paper-plane me-1"></i>Kirim Surat
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Surat Keluar --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3"><i class="fa fa-envelope-open me-2"></i>Daftar Surat Keluar</h5>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Perihal</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>ISTTS/FTI/OUT/2025/001</td>
                        <td>Balasan Undangan Seminar</td>
                        <td>Universitas Kristen Petra</td>
                        <td>2025-10-21</td>
                        <td><span class="badge bg-success">Terkirim</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-eye me-1"></i>Lihat</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>ISTTS/FTI/OUT/2025/002</td>
                        <td>Surat Rekomendasi Kegiatan</td>
                        <td>ITS Surabaya</td>
                        <td>2025-10-22</td>
                        <td><span class="badge bg-warning text-dark">Draft</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-secondary"><i class="fa fa-edit me-1"></i>Edit</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i>Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
