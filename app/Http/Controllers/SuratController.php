<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratController extends Controller
{

    public function index(Request $request)
    {
        /* ================================
         * TABEL ATAS (status: diajukan/diproses)
         * ================================ */
        $perPageTop = $request->input('per_page_top', 10);

        $queryTop = SuratTugas::query()
    ->select(
        'surat_tugas.*',
        'lecturers.full_name',
        'lecturers.lecturer_code',
        'positions.position_name',
        'positions.bureau_name'
    )
    ->join('lecturers', 'surat_tugas.nidn', '=', 'lecturers.nidn')
    ->leftJoin('position_assignments', function ($join) {
        $join->on('lecturers.nidn', '=', 'position_assignments.nidn')
             ->where('position_assignments.assignment_status', 1);
    })
    ->leftJoin('positions', 'position_assignments.position_id', '=', 'positions.position_id')
    ->whereIn('surat_tugas.status_surat', ['diajukan', 'diproses']);

        // Search tabel atas
        if ($request->filled('search_top')) {
            $search = $request->search_top;

            $queryTop->where(function ($q) use ($search) {
                $q->where('st.nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('l.full_name', 'like', "%{$search}%")
                  ->orWhere('p.position_name', 'like', "%{$search}%");
            });
        }

        $dataTop = $queryTop->groupBy('st.surat_id')
                            ->orderBy('st.created_at', 'desc')
                            ->paginate($perPageTop, ['*'], 'page_top');


        /* ================================
         * TABEL BAWAH (semua riwayat)
         * ================================ */
        $perPageBottom = $request->input('per_page_bottom', 10);

        $queryBottom = DB::table('surat_tugas AS st')
            ->join('lecturers AS l', 'st.nidn', '=', 'l.nidn')
            ->leftJoin('position_assignments AS pa', function ($join) {
                $join->on('l.nidn', '=', 'pa.nidn')
                     ->where('pa.assignment_status', 1);
            })
            ->leftJoin('positions AS p', 'pa.position_id', '=', 'p.position_id')
            ->select(
                'st.*',
                'l.full_name',
                'l.lecturer_code',
                'p.position_name',
                'p.bureau_name'
            );

        // Search tabel bawah
        if ($request->filled('search_bottom')) {
            $search = $request->search_bottom;

            $queryBottom->where(function ($q) use ($search) {
                $q->where('st.nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('l.full_name', 'like', "%{$search}%")
                  ->orWhere('p.position_name', 'like', "%{$search}%");
            });
        }

        $dataBottom = $queryBottom->distinct()
                                    ->orderBy('st.created_at', 'desc')
                                  ->paginate($perPageBottom, ['*'], 'page_bottom');


        return view('dashboard.index', compact('dataTop', 'dataBottom'));
    }


    /**
     * Preview surat sebelum diproses
     */
    public function preview($id)
    {
        $surat = DB::table('surat_tugas AS st')
            ->leftJoin('lecturers AS l', 'l.nidn', '=', 'st.nidn')
            ->select(
                'st.*',
                'l.full_name AS nama_pengaju'
            )
            ->where('st.surat_id', $id)
            ->first();

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }

        return view('dashboard.preview', compact('surat'));
    }


    /**
     * Proses status tertentu (jika diperlukan)
     */
    public function proses(Request $request, $id)
    {
        DB::table('surat_tugas')
            ->where('id_surat', $id)
            ->update([
                'status_surat' => $request->status,
                'updated_at'   => now(),
            ]);

        return back()->with('success', 'Surat telah diproses.');
    }


    /**
     * ACC surat
     */
    public function acc($id)
    {
        DB::table('surat_tugas')
            ->where('surat_id', $id)
            ->update([
                'status_surat' => 'diproses',
                'updated_at'   => now(),
            ]);

        return redirect('/surat-tugas')
            ->with('success', 'Surat berhasil di-ACC.');
    }


    /**
     * Tolak surat
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string',
        ]);

        DB::table('surat_tugas')
            ->where('surat_id', $id)
            ->update([
                'status_surat'      => 'ditolak',
                'alasan_penolakan'  => $request->catatan_penolakan,
                'updated_at'        => now(),
            ]);

        return redirect('/surat-tugas')
            ->with('success', 'Surat berhasil ditolak.');
    }
}
