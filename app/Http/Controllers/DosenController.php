<?php

namespace App\Http\Controllers;

use App\Models\SuratTugas;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function dashboard()
    {
        $surat = SuratTugas::where('nidn', session('user')['nidn'])->get();
        $role = session('user')['role'];
        if (in_array($role, ['dosen'])) {
            $surat = SuratTugas::where('nidn', session('user')['nidn'])->get();
            $stats = [
                'diajukan'   => $surat->where('status_surat', 1)->count(),
                'diproses'   => $surat->whereIn('status_surat', [2, 3, 4, 5])->count(),
                'disetujui'  => $surat->where('status_surat', 6)->count(),
                'ditolak'    => $surat->where('status_surat', 0)->count(),    
            ];
            return view('dosen_kaprodi.index', compact('surat', 'stats'));
        } else {
            $statusRole = 
            [
                'kaprodi' => 1,
                'dekan'  => 3,
                'rektor'  => 4,
            ];
            $suratUntukTtd = DB::table('surat_tugas')
                ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
                ->where('surat_tugas.status_surat', $statusRole[$role])
                ->where('surat_tugas.signed_by_position_id', session('user')['jabatanId'])
                ->where('surat_tugas.nidn', '!=', session('user')['nidn'])
                ->select(
                    'surat_tugas.*',
                    'lecturers.full_name'
                )
                ->get();

            $perluTtdPemohon = DB::table('surat_tugas')
                ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
                ->select('surat_tugas.nidn', 'lecturers.full_name', DB::raw('COUNT(*) as total'))
                ->where('surat_tugas.status_surat', $statusRole[$role])
                ->where('surat_tugas.signed_by_position_id', session('user')['jabatanId'])
                ->where('surat_tugas.nidn', '!=', session('user')['nidn'])
                ->groupBy('surat_tugas.nidn', 'lecturers.full_name')
                ->orderByDesc('total')
                ->get();
        }
        $stats = [
            'diajukan'   => $surat->where('status_surat', 1)->count(),
            'diproses'   => $surat->whereIn('status_surat', [2, 3, 4, 5])->count(),
            'disetujui'  => $surat->where('status_surat', 6)->count(),
            'ditolak'    => $surat->where('status_surat', 0)->count(),
            'perlu_ttd'  => $suratUntukTtd->count() ?? 'null'
        ];
        return view('dekan.index', compact('surat', 'stats', 'suratUntukTtd', 'perluTtdPemohon'));
        // elseif ($role === 'kaprodi') return view('kaprodi.index', compact('surat', 'stats', 'suratUntukTtd', 'perluTtdPemohon'));
    }
    // public function dosen_dashboard()
    // {
    //     $surat = SuratTugas::where('nidn', session('user')['nidn'])->get();
    //     $stats = [
    //         'diajukan'   => $surat->where('status_surat', 1)->count(),
    //         'diproses'   => $surat->whereIn('status_surat', [2, 3, 4, 5])->count(),
    //         'disetujui'  => $surat->where('status_surat', 6)->count(),
    //         'ditolak'    => $surat->where('status_surat', 0)->count(),
    //     ];
    //     // dd($surat);

    //     return view('dosen_kaprodi.index', compact('surat', 'stats'));
    // }
    // public function kaprodi_dashboard()
    // {
    //     $user = session('user');
    //     // $parentId = Position::where('position_id', session('user')['jabatanId'])->value('parent_position_id');
    //     // dd($parentId);

    //     $surat = SuratTugas::where('nidn', $user['nidn'])->get();

    //     $positionId = session('user')['jabatanId'];

    //     $suratUntukTtd = DB::table('surat_tugas')
    //         ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
    //         ->where('surat_tugas.status_surat', 1)
    //         ->where('surat_tugas.signed_by_position_id', $positionId)
    //         ->where('surat_tugas.nidn', '!=', $user['nidn'])
    //         ->select(
    //             'surat_tugas.*',
    //             'lecturers.full_name'
    //         )
    //         ->get();

    //     $perluTtdPemohon = DB::table('surat_tugas')
    //         ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
    //         ->select('surat_tugas.nidn', 'lecturers.full_name', DB::raw('COUNT(*) as total'))
    //         ->where('surat_tugas.status_surat', 1)
    //         ->where('surat_tugas.signed_by_position_id', $positionId)
    //         ->where('surat_tugas.nidn', '!=', $user['nidn'])
    //         ->groupBy('surat_tugas.nidn', 'lecturers.full_name')
    //         ->orderByDesc('total')
    //         ->get();

    //     // Statistik
    //     $stats = [
    //         'diajukan'   => $surat->where('status_surat', 1)->count(),
    //         'diproses'   => $surat->whereIn('status_surat', [2, 3, 4, 5])->count(),
    //         'disetujui'  => $surat->where('status_surat', 6)->count(),
    //         'ditolak'    => $surat->where('status_surat', 0)->count(),
    //         'perlu_ttd'  => $suratUntukTtd->count()
    //     ];

    //     return view('kaprodi.index', compact('surat', 'stats', 'suratUntukTtd', 'perluTtdPemohon'));
    // }
    // public function dekan_dashboard()
    // {
    //     $user = session('user');

    //     if ($user['role'] == 'dekan'){
    //         $surat = SuratTugas::where('status_surat','>=',3)->get();
    //     }
    //     else{
    //         // Semua surat milik user
    //         $surat = SuratTugas::where('status_surat','>=',0)->where('nidn', '=', $user['nidn'])->get();
    //     }

    //     $userNidn = session('user.nidn');

    //     // Cari posisi berdasarkan prefix
    //     $positionId = session('user')['jabatanId'];

    //     // Ambil surat untuk ditandatangani dengan rule tambahan
    //     $suratUntukTtd = DB::table('surat_tugas')
    //         ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
    //         ->where('surat_tugas.status_surat', 3)
    //         ->where('surat_tugas.signed_by_position_id', $positionId)
    //         ->where('surat_tugas.nidn', '!=', $user['nidn'])
    //         ->select(
    //             'surat_tugas.*',
    //             'lecturers.full_name'
    //         )
    //         ->get();

    //     $perluTtdPemohon = DB::table('surat_tugas')
    //         ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
    //         ->select('surat_tugas.nidn', 'lecturers.full_name', DB::raw('COUNT(*) as total'))
    //         ->where('surat_tugas.status_surat', 3)
    //         ->where('surat_tugas.signed_by_position_id', $positionId)
    //         ->where('surat_tugas.nidn', '!=', $user['nidn'])
    //         ->groupBy('surat_tugas.nidn', 'lecturers.full_name')
    //         ->orderByDesc('total')
    //         ->get();

    //     // Statistik
    //     $stats = [
    //         'diajukan'   => SuratTugas::where('status_surat', 1)->count(),
    //         'diproses'   => SuratTugas::whereIn('status_surat', [2, 3, 4, 5])->count(),
    //         'disetujui'  => SuratTugas::where('status_surat', 6)->count(),
    //         'ditolak'    => SuratTugas::where('status_surat', 0)->count(),
    //         'perlu_ttd'  => $suratUntukTtd->count()
    //     ];

    //     return view('dekan.index', compact('surat', 'stats', 'suratUntukTtd', 'perluTtdPemohon'));
    // }

    // public function rektor_dashboard()
    // {
    //     $user = session('user');

    //     if ($user['role'] == 'rektor'){
    //         $surat = SuratTugas::where('status_surat','>=',4)->get();
    //     }
    //     else{
    //         // Semua surat milik user
    //         $surat = SuratTugas::where('status_surat','>=',0)->where('nidn', '=', $user['nidn'])->get();
    //     }

    //     $userNidn = session('user.nidn');

    //     // Cari posisi berdasarkan prefix
    //     $positionId = session('user')['jabatanId'];
    //     // Ambil surat untuk ditandatangani dengan rule tambahan
    //     $suratUntukTtd = DB::table('surat_tugas')
    //         ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
    //         ->where('surat_tugas.status_surat', 4)
    //         ->where('surat_tugas.nidn', '!=', session('user')['nidn'])
    //         ->select(
    //             'surat_tugas.*',
    //             'lecturers.full_name'
    //         )
    //         ->get();

    //     $perluTtdPemohon = DB::table('surat_tugas')
    //         ->join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
    //         ->select('surat_tugas.nidn', 'lecturers.full_name', DB::raw('COUNT(*) as total'))
    //         ->where('surat_tugas.nidn', '!=', session('user')['nidn'])
    //         ->groupBy('surat_tugas.nidn', 'lecturers.full_name')
    //         ->orderByDesc('total')
    //         ->get();

    //     // Statistik
    //     $stats = [
    //         'diajukan'   => SuratTugas::where('status_surat', 1)->count(),
    //         'diproses'   => SuratTugas::whereIn('status_surat', [2, 3, 4, 5])->count(),
    //         'disetujui'  => SuratTugas::where('status_surat', 6)->count(),
    //         'ditolak'    => SuratTugas::where('status_surat', 0)->count(),
    //         'perlu_ttd'  => $suratUntukTtd->count()
    //     ];

    //     return view('rektor.index', compact('surat', 'stats', 'suratUntukTtd', 'perluTtdPemohon'));
    // }

    
}
