<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratController extends Controller
{
    public function surat()
    {
        // Set options terlebih dahulu
        Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);

        // Load view utama
        $pdf = Pdf::loadView('CRUD_Surat.cetak_surat', [
            // Data yang ingin dikirim ke view bisa ditaruh di sini
            // 'nama' => 'Erick'
        ]);

        // Download file
        return $pdf->download('surat_tugas.pdf');
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        
        // Mulai Query dari tabel surat_tugas
        $query = DB::table('surat_tugas as st')
            // 1. Join ke Lecturers untuk dapat Nama Dosen (Penganju)
            ->join('lecturers as l', 'st.employee_nip', '=', 'l.employee_nip')
            
            // 2. Join ke Position Assignments (Cari jabatan yang AKTIF saja / status=1)
            ->leftJoin('position_assignments as pa', function($join) {
                $join->on('l.employee_nip', '=', 'pa.employee_nip')
                     ->where('pa.assignment_status', '=', 1);
            })
            
            // 3. Join ke Positions untuk dapat Nama Jabatan (misal: Operations Lead)
            ->leftJoin('positions as p', 'pa.position_id', '=', 'p.position_id')
            
            // Pilih kolom yang mau ditampilkan
            ->select(
                'st.*',                 // Semua data surat tugas
                'l.lecturer_name',      // Nama Dosen
                'p.position_name',      // Nama Jabatan
                'p.bureau_name'         // Nama Biro (Opsional, bisa jadi Penyelenggara)
            );

        // Logika Search
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('st.nama_kegiatan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('l.lecturer_name', 'like', '%' . $searchTerm . '%');
            });
        }

        // Order by terbaru & Pagination
        $data = $query->orderBy('st.created_at', 'desc')->paginate($perPage);

        $data->appends(['search' => $request->search, 'per_page' => $perPage]);

        return view('dashboard.index', compact('data'));
    }
}
