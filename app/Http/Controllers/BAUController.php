<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratTugas;

class BAUController extends Controller
{
    public function dashboard(Request $request)
{
    // Ambil nilai filter dari request
    $bulan = $request->bulan;
    $tahun = $request->tahun;
    $status = $request->status;

    // Query awal
$query = SuratTugas::join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
    ->select('surat_tugas.*', 'lecturers.full_name', 'lecturers.role');

// FILTER berdasarkan role pembuat surat
$query->where(function ($q) {
    // Jika role bukan dekan → status >= 4
    $q->where(function ($q2) {
        $q2->where('lecturers.role', '!=', 'dekan')
           ->where('surat_tugas.status_surat', '>=', 4);
    })
    // Jika role dekan → status = 5
    ->orWhere(function ($q2) {
        $q2->where('lecturers.role', 'dekan')
           ->where('surat_tugas.status_surat', 5);
    });
});

$surat = $query->get();


    // Filter bulan
    if (!empty($bulan)) {
        $bulanAngka = [
            "Januari" => 1, "Februari" => 2, "Maret" => 3, "April" => 4,
            "Mei" => 5, "Juni" => 6, "Juli" => 7, "Agustus" => 8,
            "September" => 9, "Oktober" => 10, "November" => 11, "Desember" => 12
        ][$bulan] ?? null;

        if ($bulanAngka) {
            $query->whereMonth('tanggal_surat', $bulanAngka);
        }
    }

    // Filter tahun
    if (!empty($tahun)) {
        $query->whereYear('tanggal_surat', $tahun);
    }

    // Filter status (ambil angka dalam kurung)
    if (!empty($status)) {
        if (preg_match('/\((\d+)\)/', $status, $match)) {
            $query->where('status_surat', $match[1]);
        }
    }

    // Eksekusi query
    $surat = $query->get();


    // Statistik disesuaikan filter atau tetap full (sesuai kebutuhan)
    $stats = [
        'total'      => SuratTugas::count(),
        'diajukan'   => SuratTugas::where('status_surat', 1)->count(),
        'diproses'   => SuratTugas::whereIn('status_surat', [2, 3, 4, 5])->count(),
        'disetujui'  => SuratTugas::where('status_surat', 6)->count(),
        'ditolak'    => SuratTugas::where('status_surat', 0)->count(),
    ];

    return view('bau.index', compact('surat', 'stats', 'bulan', 'tahun', 'status'));
}


    
}
