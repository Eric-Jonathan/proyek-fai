@extends('layouts.app')

@section('title', 'Dashboard Surat Tugas')

@section('content')
<div class="container-fluid mt-4">
    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Dashboard Surat Tugas</h4>
    </div>

    {{-- Statistik Surat --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-info card-blue">
                <div><strong>Diajukan</strong><br>12 Surat</div>
                <i class="fa fa-paper-plane fa-2x"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-info card-purple">
                <div><strong>Diproses</strong><br>8 Surat</div>
                <i class="fa fa-hourglass-half fa-2x"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-info card-green">
                <div><strong>Disetujui</strong><br>25 Surat</div>
                <i class="fa fa-check-circle fa-2x"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-info card-red">
                <div><strong>Ditolak</strong><br>3 Surat</div>
                <i class="fa fa-times-circle fa-2x"></i>
            </div>
        </div>
    </div>

    {{-- Grafik Statistik --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="chart">
                <h6>Status Surat Tugas</h6>
                <canvas id="chartStatus" class="pb-3"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart">
                <h6>Distribusi Surat per Prodi</h6>
                <canvas id="chartProdi" class="pb-3"></canvas>
            </div>
        </div>
    </div>

    {{-- Daftar Surat Pengajuan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-semibold"><i class="fa fa-list me-2"></i>Daftar Pengajuan Surat Tugas</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-secondary">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama Dosen</th>
                        <th>Jenis Kegiatan</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dr. Alexander Erick</td>
                        <td>Surat Tugas</td>
                        <td>Seminar AI di ITS</td>
                        <td>10-11 Nov 2025</td>
                        <td><span class="badge bg-warning">Diproses</span></td>
                        <td class="text-center">
                            <button onclick="openDetailSurat({ nomor: 'ST/2025/001' })" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
                            <button onclick="openModalTolak()" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Johansen Kennedy</td>
                        <td>Assesor BKD</td>
                        <td>Evaluasi BKD FTI</td>
                        <td>3-4 Des 2025</td>
                        <td><span class="badge bg-success">Disetujui</span></td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Riwayat Persetujuan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-semibold"><i class="fa fa-history me-2"></i>Riwayat Persetujuan & Keputusan</h6>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Kaprodi FTI</strong> menyetujui surat tugas "Seminar AI di ITS" pada <em>8 Nov 2025</em>.
                </li>
                <li class="list-group-item">
                    <strong>Dekan FST</strong> menandatangani surat tugas "Evaluasi BKD FTI" pada <em>4 Des 2025</em>.
                </li>
            </ul>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {

        // === Chart 1: Status Surat Tugas ===
        const ctxStatus = document.getElementById("chartStatus").getContext("2d");
        new Chart(ctxStatus, {
            type: "doughnut",
            data: {
                labels: ["Diajukan", "Diproses", "Disetujui", "Ditolak"],
                datasets: [{
                    data: [12, 8, 25, 3],
                    backgroundColor: [
                        "rgba(54, 162, 235, 0.8)",   // Diajukan - biru
                        "rgba(153, 102, 255, 0.8)",  // Diproses - ungu
                        "rgba(75, 192, 192, 0.8)",   // Disetujui - hijau
                        "rgba(255, 99, 132, 0.8)"    // Ditolak - merah
                    ],
                    borderColor: "#fff",
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: { font: { size: 13 } }
                    },
                    title: {
                        display: false
                    }
                }
            }
        });

        // === Chart 2: Distribusi Surat per Prodi ===
        const ctxProdi = document.getElementById("chartProdi").getContext("2d");
        new Chart(ctxProdi, {
            type: "bar",
            data: {
                labels: ["Informatika", "Sistem Informasi", "Elektro", "Bioteknologi", "Matematika"],
                datasets: [{
                    label: "Jumlah Surat",
                    data: [15, 10, 6, 8, 12],
                    backgroundColor: "rgba(54, 162, 235, 0.8)",
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 2
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12 }
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: "#333",
                        titleFont: { size: 13 },
                        bodyFont: { size: 12 }
                    }
                }
            }
        });

    });

    function openDetailSurat(data) {
        document.querySelector("#modalDetailSurat td:nth-child(2)").innerText = data.nomor;
        // dan set elemen lain sesuai data JSON
        const modal = new bootstrap.Modal(document.getElementById('modalDetailSurat'));
        modal.show();
    }

    function openModalTolak() {
        // dan set elemen lain sesuai data JSON
        const modal = new bootstrap.Modal(document.getElementById('modalTolakSurat'));
        modal.show();
    }
    </script>
@endsection