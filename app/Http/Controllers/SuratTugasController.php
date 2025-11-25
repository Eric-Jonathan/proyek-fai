<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\SuratTugas;
use App\Models\SuratTemplate;
use Illuminate\Http\Request;

class SuratTugasController extends Controller
{
    // Tampilkan form pengajuan surat tugas
    // public function create()
    // {
    //     // Ambil template surat untuk dropdown
    //     $templates = SuratTemplate::all();

    //     // Ambil nip user yang login (nanti ganti sesuai auth)
    //     $employeeNip = auth()->user()->employee_nip ?? null;

    //     return view('surat_tugas.create', compact('templates', 'employeeNip'));
    // }

    public function create()
    {
        $positions = Position::all();

        $nomor_surat = app('App\Services\NomorSuratService')->generatePreview();

        return view('CRUD_Surat.form_surat', [
            'positions' => $positions,
            'nomor_surat' => $nomor_surat
        ]);
    }

    // Simpan pengajuan surat tugas
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_nip' => 'required|exists:lecturers,employee_nip',
            'template_id' => 'required|exists:surat_templates,template_id',
            
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_tugas' => 'required|string|max:255',
            'dasar_tugas' => 'required|string',
            'sifat' => 'required|string|max:50',
            'tujuan' => 'required|string',
            'waktu_pelaksanaan' => 'required|string|max:255',

            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',

            'lampiran' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Upload lampiran jika ada
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_surat', 'public');
        }

        // Buat record surat
        SuratTugas::create([
            ...$validated,
            'lampiran_path' => $lampiranPath,
            'tanggal_surat' => now()->format('Y-m-d'),
            'status_surat' => 'diajukan',
        ]);

        return redirect()->route('surat-tugas.create')
            ->with('success', 'Pengajuan surat tugas berhasil dikirim!');
    }
}
