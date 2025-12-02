<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\SuratTugas;
use App\Models\SuratTemplate;
use Illuminate\Http\Request;

class SuratTugasController extends Controller
{
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
        // dd( session('user.jabatan'));

        $validated = $request->validate([
            'jenis_tugas'        => 'required|string|max:255',
            'dasar_tugas'        => 'required|string',            
            'sifat_surat'        => 'required|string|max:50',   // dari form -> nanti mapping
            'tujuan'             => 'required|string',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
            'lampiran'           => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Ambil NIDN dari session
        $nidn = session('user.nidn');

        if (!$nidn) {
            return back()->with('error', 'Session user tidak ditemukan.');
        }

        // Upload file
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_surat', 'public');
        }

        // SIMPAN DATA KE DATABASE
        SuratTugas::create([
            'nidn'               => $nidn,
            'template_id'        => 1,                          // tidak ada di form
            'nomor_surat'        => $nomorPreview = app('App\Services\NomorSuratService')->generateFinal(), 
            'jabatan'            => session('user.jabatan'),      // dari form        
            'jenis_tugas'        => $validated['jenis_tugas'],
            'dasar_tugas'        => $validated['dasar_tugas'],
            'sifat'              => $validated['sifat_surat'],         // mapping
            'tujuan'             => $validated['tujuan'],
            'waktu_pelaksanaan'  => $validated['tanggal_mulai'] . ' s/d ' . $validated['tanggal_selesai'],
            'tanggal_mulai'      => $validated['tanggal_mulai'],
            'tanggal_selesai'    => $validated['tanggal_selesai'],
            'tanggal_surat'      => now()->format('Y-m-d'),
            'lampiran_path'      => $lampiranPath,
            'status_surat'       => 'diajukan',
            'signed_by_position_id' => session('user.parent_position_id'),  // dari session
        ]);
    
        return redirect()->route(session('user.role') . '.dashboard')
            ->with('success', 'Pengajuan surat tugas berhasil dikirim!');
    }
}
