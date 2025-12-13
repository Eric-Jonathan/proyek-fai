<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\LogAktivitas;
use App\Models\Position;
use App\Models\PositionAssignment;
use App\Models\SuratTugas;
use App\Models\SuratTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratTugasController extends Controller
{
    public function surat($id)
    {
        // Set options terlebih dahulu
        Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);
        $user = session('user');
        $surat = SuratTugas::with(['signedByPosition.parent'])->find($id);

        $lecturer = Lecturer::where('nidn', $surat['nidn'])->first();

        $positionAssignment = PositionAssignment::where('nidn', $lecturer->nidn)
            ->with('position.parent') // ambil posisi dan parent-nya
            ->first();
        $parent = $positionAssignment->position->parent;
        $parentAssignment = PositionAssignment::where('position_id', $parent->parent_position_id)->first();
        $atasan = Lecturer::where('nidn', $parentAssignment->nidn)->first();

        // Contoh: return ke view
        return Pdf::loadView('CRUD_Surat.cetak_surat', [
            'surat' => $surat,
            'lecturer' => $lecturer,
            'parentAssignment' => $parentAssignment, // ini ganti $atasan
            'user' => $user,
            'atasan' => $atasan
        ])->download('surat_tugas_' . $surat->surat_id . '.pdf');
    }

    public function preview_pdf($id)
    {
        // Enable PDF Options
        Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
        ]);

        $user = session('user');
        $surat = SuratTugas::with(['signedByPosition.parent'])->find($id);

        $lecturer = Lecturer::where('nidn', $surat['nidn'])->first();

        $positionAssignment = PositionAssignment::where('nidn', $lecturer->nidn)
            ->with('position.parent')
            ->first();

        $parent = $positionAssignment->position->parent;

        $parentAssignment = PositionAssignment::where('position_id', $parent->parent_position_id)->first();

        $atasan = Lecturer::where('nidn', $parentAssignment->nidn)->first();

        return view('CRUD_Surat.preview_pdf', [
            'surat' => $surat,
            'lecturer' => $lecturer,
            'parentAssignment' => $parentAssignment,
            'user' => $user,
            'atasan' => $atasan
        ]);
    }

    
    public function create()
    {
        $parentId = Position::where('position_id', session('user')['jabatanId'])->value('parent_position_id');
        // dd($parentId)
        $nomor_surat = app('App\Services\NomorSuratService')->generatePreview();

        $lecturer = Lecturer::where('nidn', session('user.nidn'))
                            ->with('activePositionAssignment.position')
                            ->first();

        $jabatan = optional($lecturer->activePosition())->position_name;

        return view('CRUD_Surat.form_surat', [
            'lecturer'    => $lecturer,
            'jabatan'     => $jabatan,
            'nomor_surat' => $nomor_surat,
            'signed_by_position_id' => $parentId
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
            'lampiran' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',        ]);
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

        $status=0;
        if (session('user')['jabatanId'] <= 12) {
            if(session('user')['jabatanId'] <= 3 && $validated['sifat_surat'] == 'Non-Dinas'){
                $status = 6;
            } else {
                $status = 2;
            }
        } else {
            $status = 1;
        }

        // dd($validated['sifat_surat']);
        //'Non-Dinas'
        // $sifat = $validated['sifat_surat'];
        // if($validated['sifat_surat'] == 'Non-Dinas'){}

        // SIMPAN DATA KE DATABASE
        SuratTugas::create([
            'nidn'               => $nidn,
            'template_id'        => 1,                          // tidak ada di form
            'nomor_surat'        => $nomorPreview = app('App\Services\NomorSuratService')->generateFinal(), 
            // 'jabatan'            => $request->jabatan,   
            'jenis_tugas'        => $validated['jenis_tugas'],
            'dasar_tugas'        => $validated['dasar_tugas'],
            'sifat'              => $validated['sifat_surat'],         // mapping
            'tujuan'             => $validated['tujuan'],
            'waktu_pelaksanaan'  => $validated['tanggal_mulai'] . ' s/d ' . $validated['tanggal_selesai'],
            'tanggal_mulai'      => $validated['tanggal_mulai'],
            'tanggal_selesai'    => $validated['tanggal_selesai'],
            'tanggal_surat'      => now()->format('Y-m-d'),
            'lampiran_path'      => $lampiranPath,
            'status_surat'       => $status,
            'signed_by_position_id' => session('user.parent_position_id'),  // dari session
        ]);
        LogAktivitas::create([
            'nidn'       => $nidn,
            'aktivitas'  => 'Pengajuan Surat Tugas',
            'module'     => 'Surat_Tugas',
            'module_id'  => null,
            'keterangan' => 'Diajukan oleh dosen dengan NIDN: ' . $nidn,
        ]);
        return redirect()->route(session('user.role') . '.dashboard')
            ->with('success', 'Pengajuan surat tugas berhasil dikirim!');
    }

    public function index(Request $request)
    {
        /* ================================
         * TABEL ATAS (status: diajukan/diproses)
         * ================================ */
        $perPageTop = $request->input('per_page_top', 10);

        $queryTop = SuratTugas::from('surat_tugas AS st')
            ->select(
                'st.*',
                'l.full_name',
                'l.lecturer_code',
                'p.position_name',
                'p.bureau_name'
            )
            ->join('lecturers AS l', 'st.nidn', '=', 'l.nidn')
            ->leftJoin('position_assignments AS pa', function ($join) {
                $join->on('l.nidn', '=', 'pa.nidn')
                     ->where('pa.assignment_status', 1);
            })
            ->leftJoin('positions AS p', 'pa.position_id', '=', 'p.position_id')
            ->whereIn('st.status_surat', ['diajukan', 'diproses']);

        // Search tabel atas
        if ($request->filled('search_top')) {
            $search = $request->search_top;

            $queryTop->where(function ($q) use ($search) {
                $q->where('st.nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('l.full_name', 'like', "%{$search}%")
                  ->orWhere('p.position_name', 'like', "%{$search}%");
            });
        }

        $dataTop = $queryTop
        ->distinct('st.surat_id')
            ->orderBy('st.created_at', 'desc')
            ->paginate($perPageTop, ['*'], 'page_top');

        $dataTop->setCollection(
        $dataTop->getCollection()->unique('surat_id')->values()
        );


        /* ================================
         * TABEL BAWAH (semua riwayat)
         * ================================ */
        $perPageBottom = $request->input('per_page_bottom', 10);

        $queryBottom = SuratTugas::from('surat_tugas AS st')
            ->select(
                'st.*',
                'l.full_name',
                'l.lecturer_code',
                'p.position_name',
                'p.bureau_name'
            )
            ->join('lecturers AS l', 'st.nidn', '=', 'l.nidn')
            ->leftJoin('position_assignments AS pa', function ($join) {
                $join->on('l.nidn', '=', 'pa.nidn')
                     ->where('pa.assignment_status', 1);
            })
            ->leftJoin('positions AS p', 'pa.position_id', '=', 'p.position_id');

        // Search tabel bawah
        if ($request->filled('search_bottom')) {
            $search = $request->search_bottom;

            $queryBottom->where(function ($q) use ($search) {
                $q->where('st.nama_kegiatan', 'like', "%{$search}%")
                  ->orWhere('l.full_name', 'like', "%{$search}%")
                  ->orWhere('p.position_name', 'like', "%{$search}%");
            });
        }

        $dataBottom = $queryBottom
        ->distinct('st.surat_id')
            ->orderBy('st.created_at', 'desc')
            ->paginate($perPageBottom, ['*'], 'page_bottom');

        $dataBottom->setCollection(
        $dataBottom->getCollection()->unique('surat_id')->values()
        );


        return view('dashboard.index', compact('dataTop', 'dataBottom'));
    }

    public function preview($id)
    {
        $surat = SuratTugas::from('surat_tugas AS st')
        ->select(
            'st.*',
            'l.full_name AS nama_pengaju'
        )
        ->leftJoin('lecturers AS l', 'l.nidn', '=', 'st.nidn')
        ->where('st.surat_id', $id)
        ->first();

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }        
        return view('dashboard.preview', compact('surat'));
    }

    public function detail($id)
    {
        // $parentId = Position::where('position_id', session('user')['jabatanId'])->value('parent_position_id');
        // dd($parentId);

        $surat = SuratTugas::from('surat_tugas AS st')
        ->select(
            'st.*',
            'l.full_name AS nama_pengaju'
        )
        ->leftJoin('lecturers AS l', 'l.nidn', '=', 'st.nidn')
        ->where('st.surat_id', $id)
        ->first();
        // dd($surat);

        if (!$surat) {
            abort(404, 'Surat tidak ditemukan');
        }

        return view('dashboard.detail', compact('surat'));
    }


    /*** Proses status tertentu (jika diperlukan) */
    public function proses(Request $request, $id)
    {
        $surat = SuratTugas::where('id_surat', $id)->firstOrFail();
        $surat->status_surat = $request->status;
        $surat->save();

        return back()->with('success', 'Surat telah diproses.');
    }


    /*** ACC surat */
    // 2-3 -> dekan (status -> 2)
    // 4-12 -> kaprodi (status -> 2)
    //12 -> 21, 11 -> 20, 10 -> 19, 9 -> 18, 8 -> 17, 7 -> 16, 6 -> 15, 5 -> 14, 4 -> 13
    //3 -> [10, 11], 2 -> [12, 9-4]
    public function acc($id)
    {
        $surat = SuratTugas::findOrFail($id);
        $nidn = session('user')['nidn'] ?? null;
        $role = session('user')['role'] ?? null;
        $lecturer = Lecturer::where('nidn', $surat->nidn)->first();
        $xrole = $lecturer->role ?? null;
        $parentId = Position::where('position_id', session('user')['jabatanId'])->value('parent_position_id');

        $statusLabels = [
            -1 => 'delete',
            0  => 'ditolak',
            1  => 'diajukan',
            2  => 'disetujui_kaprodi',
            3  => 'diproses_sekretaris',
            4  => 'disetujui_dekan',
            5  => 'menunggu_stempel',
            6  => 'selesai',
        ];
// dd($surat['sifat']);

        // --- LOGIKA STATUS SURAT ---
        if ($surat->status_surat == 3 && $xrole != 'dekan') {
            // skip rektor 
            $surat->status_surat = 5;
        
        } else {
        
            if ($surat->signed_by_position_id == 1) {
                //dekan
                $surat->status_surat += 2;
            
            } else {
                if($parentId != null){ //sekretaris
                    $surat->signed_by_position_id = $parentId;
                }
                $surat->status_surat += 1;
                if ($role == 'kaprodi' && $surat['sifat'] == 'Non-Dinas') {
                    $surat->status_surat = 6;
                }
            }
        }


        $surat->save();
        LogAktivitas::create([
            'nidn'       => $nidn,
            'aktivitas'  => 'Surat Tugas' . $statusLabels[$surat->status_surat],
            'module'     => 'Surat_Tugas',
            'module_id'  => $id,
            'keterangan' => 'Surat dengan ID: ' . $id . ' di-ACC oleh ' . $role,
        ]);
        return redirect()->route(session('user.role') . '.dashboard')
            ->with('success', 'Surat berhasil disetujui!');
    }



    /*** Tolak surat */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'catatan_penolakan' => 'required|string',
        ]);

        $statusLabels = [
            -1 => 'Dihapus',
            0  => 'Ditolak',
            1  => 'Diajukan',
            2  => 'Kaprodi',
            3  => 'Sekretaris',
            4  => 'Dekan',
            5  => 'BAU',
            6  => 'Selesai',
        ];

        $surat = SuratTugas::findOrFail($id);
        $nidn = session('user')['nidn'] ?? null;

        // Update surat
        LogAktivitas::create([
            'nidn'       => $nidn,
            'aktivitas'  => 'Penolakan Surat Tugas',
            'module'     => 'Surat_Tugas',
            'module_id'  => $id,
            'keterangan' => 'Surat dengan ID: ' . $id . ' ditolak oleh ' . $statusLabels[$surat->status_surat + 1],
        ]);
        $surat->status_surat = 0;
        $surat->alasan_penolakan = $request->catatan_penolakan;
        $surat->save();
        return redirect()->route(session('user.role') . '.dashboard')
            ->with('success', value: 'Surat berhasil ditolak oleh ' . $statusLabels[$surat->status_surat + 1]);

    }

    public function riwayat_surat()
    {
        $role = session('user')['role'] ?? null;
        $nidn = session('user')['nidn'] ?? null;
        if (in_array($role, ['admin', 'rektor'])) {
            $surat = SuratTugas::join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
            ->select('surat_tugas.*', 'lecturers.full_name')
            ->get();
        } elseif (in_array($role, ['dosen', 'kaprodi', 'dekan'])) {
            $surat = SuratTugas::join('lecturers', 'lecturers.nidn', '=', 'surat_tugas.nidn')
                ->where('surat_tugas.nidn', $nidn)   // ← ini benar
                ->select('surat_tugas.*', 'lecturers.full_name')
                ->get();

        } else {
            abort(403, 'Role pengguna tidak dikenali.');
        }

        return view('admin.riwayat_surat', compact('surat'));
    }

    public function edit($id)
    {
        $surat = SuratTugas::with('lecturer')->findOrFail($id);

        return view('CRUD_Surat.edit_surat', compact('surat'));
        
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'jabatan' => 'required',
            'jenis_tugas' => 'required',
            'dasar_tugas' => 'required',
            'sifat_surat' => 'required',
            'tujuan' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lampiran' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $surat = SuratTugas::findOrFail($id);

        // $surat->jabatan = $request->jabatan;
        $surat->jenis_tugas = $request->jenis_tugas;
        $surat->dasar_tugas = $request->dasar_tugas;
        $surat->sifat = $request->sifat_surat;
        $surat->tujuan = $request->tujuan;
        $surat->tanggal_mulai = $request->tanggal_mulai;
        $surat->tanggal_selesai = $request->tanggal_selesai;
        
        // Upload lampiran baru
        if ($request->hasFile('lampiran')) {

            // Delete file lama
            if ($surat->lampiran_path && Storage::disk('public')->exists($surat->lampiran_path)) {
                Storage::disk('public')->delete($surat->lampiran_path);
            }

            // Simpan file baru
            $path = $request->file('lampiran')->store('lampiran_surat', 'public');

            // Update kolom sesuai tabel
            $surat->lampiran_path = $path;
        }

        $surat->save();

        LogAktivitas::create([
            'nidn'       => session('user')['nidn'] ?? null,
            'aktivitas'  => 'Update Surat Tugas',
            'module'     => 'Surat_Tugas',
            'module_id'  => $id,
            'keterangan' => 'Surat dengan ID: ' . $id . ' diperbarui.',
        ]);

        return redirect()->route(session('user.role') . '.dashboard')
            ->with('success', 'Surat tugas berhasil diperbarui!');
    }
}
