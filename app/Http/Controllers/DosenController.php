<?php

namespace App\Http\Controllers;

use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function dosen_dashboard()
    {
        $user = session('user');
        $surat = SuratTugas::where('nidn', $user['nidn'])->get();
        $stats = [
            'diajukan'   => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 1)->count(),
            'diproses'   => SuratTugas::where('nidn', $user['nidn'])->whereIn('status_surat', [2, 3, 4])->count(),
            'disetujui'  => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 5)->count(),
            'ditolak'    => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 0)->count(),
        ];

        return view('dosen_kaprodi.index', compact('surat', 'stats'));
    }
    public function kaprodi_dashboard()
    {
        $user = session('user');

        // Semua surat milik user
        $surat = SuratTugas::where('nidn', $user['nidn'])->get();

        $userNidn = session('user.nidn');

        // Ambil prefix dari lecturer_code
        $userKode = DB::table('lecturers')
            ->where('nidn', $userNidn)
            ->value(DB::raw("REGEXP_SUBSTR(lecturer_code, '^[A-Z]+')"));

        // Cari posisi berdasarkan prefix
        $positionId = DB::table('positions')
            ->where('position_code', 'LIKE', "%{$userKode}%")
            ->value('position_id');

        // Ambil surat untuk ditandatangani dengan rule tambahan
        $suratUntukTtd = DB::table('surat_tugas')
            ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
            ->where('surat_tugas.status_surat', 1)
            ->where('surat_tugas.signed_by_position_id', $positionId)
            ->where('surat_tugas.nidn', '!=', $userNidn)
            ->select(
                'surat_tugas.*',
                'lecturers.full_name'
            )
            ->get();

        $perluTtdPemohon = DB::table('surat_tugas')
            ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
            ->select('surat_tugas.nidn', 'lecturers.full_name', DB::raw('COUNT(*) as total'))
            ->where('surat_tugas.status_surat', 1)
            ->where('surat_tugas.nidn', '!=', $userNidn)
            ->groupBy('surat_tugas.nidn', 'lecturers.full_name')
            ->orderByDesc('total')
            ->get();

        // Statistik
        $stats = [
            'diajukan'   => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 1)->count(),
            'diproses'   => SuratTugas::where('nidn', $user['nidn'])->whereIn('status_surat', [2, 3, 4])->count(),
            'disetujui'  => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 5)->count(),
            'ditolak'    => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 0)->count(),

            // Baru ditambahkan
            'perlu_ttd'  => $suratUntukTtd->count()
        ];

        return view('kaprodi.index', compact('surat', 'stats', 'suratUntukTtd', 'perluTtdPemohon'));
    }
    public function dekan_dashboard()
    {
        $user = session('user');

        if ($user['role'] == 'dekan'){
            $surat = SuratTugas::where('status_surat','>=',2)->where('status_surat','<=',3)->get();
        }
        else{
            // Semua surat milik user
            $surat = SuratTugas::where('status_surat','>=',0)->where('nidn', '=', $user['nidn'])->get();
        }

        $userNidn = session('user.nidn');

        // Ambil prefix dari lecturer_code
        $userKode = DB::table('lecturers')
            ->where('nidn', $userNidn)
            ->value(DB::raw("REGEXP_SUBSTR(lecturer_code, '^[A-Z]+')"));

        // Cari posisi berdasarkan prefix
        $positionId = DB::table('positions')
            ->where('position_code', 'LIKE', "%{$userKode}%")
            ->value('position_id');

        // Ambil surat untuk ditandatangani dengan rule tambahan
        $suratUntukTtd = DB::table('surat_tugas')
            ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
            ->where('surat_tugas.status_surat', 1)
            ->where('surat_tugas.signed_by_position_id', $positionId)
            ->where('surat_tugas.nidn', '!=', $userNidn)
            ->select(
                'surat_tugas.*',
                'lecturers.full_name'
            )
            ->get();

        $perluTtdPemohon = DB::table('surat_tugas')
            ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
            ->select('surat_tugas.nidn', 'lecturers.full_name', DB::raw('COUNT(*) as total'))
            ->where('surat_tugas.status_surat', 1)
            ->where('surat_tugas.nidn', '!=', $userNidn)
            ->groupBy('surat_tugas.nidn', 'lecturers.full_name')
            ->orderByDesc('total')
            ->get();


        // Statistik
        $stats = [
            'diajukan'   => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 1)->count(),
            'diproses'   => SuratTugas::where('nidn', $user['nidn'])->whereIn('status_surat', [2, 3, 4])->count(),
            'disetujui'  => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 5)->count(),
            'ditolak'    => SuratTugas::where('nidn', $user['nidn'])->where('status_surat', 0)->count(),

            // Baru ditambahkan
            'perlu_ttd'  => $suratUntukTtd->count()
        ];

        return view('kaprodi.index', compact('surat', 'stats', 'suratUntukTtd', 'perluTtdPemohon'));
    }

    
}
