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

        $lecturer = Lecturer::where('nidn', $user['nidn'])->first();

        $positionAssignment = PositionAssignment::where('nidn', $lecturer->nidn)
            ->with('position.parent') // ambil posisi dan parent-nya
            ->first();

        // Ambil posisi saat ini
        $currentPosition = $positionAssignment->position;

        // Nama posisi/role parent
        $parentRoleName = $currentPosition->parent?->position_name;

        // Contoh: return ke view
        return Pdf::loadView('CRUD_Surat.cetak_surat', [
            'surat' => $surat,
            'lecturer' => $lecturer,
            'parentRoleName' => $parentRoleName, // ini ganti $atasan
            'user' => $user
        ])->download('surat_tugas.pdf');
    }
    
    public function create()
    {
        $nomor_surat = app('App\Services\NomorSuratService')->generatePreview();

        $lecturer = Lecturer::where('nidn', session('user.nidn'))
                            ->with('activePositionAssignment.position')
                            ->first();

        $jabatan = optional($lecturer->activePosition())->position_name;

        return view('CRUD_Surat.form_surat', [
            'lecturer'    => $lecturer,
            'jabatan'     => $jabatan,
            'nomor_surat' => $nomor_surat,
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
            'status_surat'       => '1',
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
    // 2-3 -> dekan
    // 4-12 -> kaprodi
    public function acc($id)
    {
        $surat = SuratTugas::findOrFail($id);
        $nidn = session('user')['nidn'] ?? null;
        $role = session('user')['role'] ?? null;

        $userNidn = session('user.nidn');

        // Ambil prefix dari lecturer_code
        $userKode = DB::table('lecturers')
            ->where('nidn', $userNidn)
            ->value(DB::raw("REGEXP_SUBSTR(lecturer_code, '^[A-Z]+')"));

        // Cari posisi berdasarkan prefix
        $positionId = DB::table('positions')
            ->where('position_code', 'LIKE', "%{$userKode}%")
            ->value('position_id');

        $statusLabels = [
            -1 => 'delete',
            0 => 'ditolak',
            1 => 'diajukan',
            2 => 'disetujui_kaprodi',
            3 => 'diproses',
            4 => 'disetujui_dekan',
            5 => 'ditandatangani',
        ];

        // Update surat
        $surat->status_surat += 1;
        $surat->signed_by_position_id = $positionId;
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

        $userNidn = session('user.nidn');

        // Ambil prefix dari lecturer_code
        $userKode = DB::table('lecturers')
            ->where('nidn', $userNidn)
            ->value(DB::raw("REGEXP_SUBSTR(lecturer_code, '^[A-Z]+')"));

        // Cari posisi berdasarkan prefix
        $position_id = DB::table('positions')
            ->where('position_code', 'LIKE', "%{$userKode}%")
            ->value('position_id');

        $statusLabels = [
            -1 => 'delete',
            0 => 'ditolak',
            1 => 'diajukan',
            2 => 'kaprodi',
            3 => 'sekretaris',
            4 => 'dekan',
            5 => 'ditandatangani',
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
        $surat->signed_by_position_id = $position_id;
        $surat->save();
        return redirect(session('user.role') . '.dashboard')
            ->with('success', 'Surat berhasil ditolak oleh ' . $statusLabels[$surat->status_surat + 1]);
    }

    public function riwayat_surat()
    {
        $role = session('user')['role'] ?? null;
        $nidn = session('user')['nidn'] ?? null;
        if ($role === 'admin') {
            $surat = SuratTugas::all();

            $dataTop = SuratTugas::whereNotIn('status_surat', [0, 5])
                        ->paginate(request('per_page') ?? 10)
                        ->appends(request()->query());

            $dataBottom = SuratTugas::whereIn('status_surat', [0, 5])
                        ->paginate(request('per_page') ?? 10)
                        ->appends(request()->query());
        } elseif ($role === 'dosen') {
            $surat = SuratTugas::where('nidn', $nidn);
            // Data yang sedang diproses (kecuali ditolak dan ditandatangani)
            $dataTop = $surat->whereNotIn('status_surat', [0, 5])
                             ->paginate(request('per_page') ?? 10)
                             ->appends(request()->query());

            // Clone query untuk bagian bottom (karena query sebelumnya sudah digunakan)
            $dataBottom = SuratTugas::where('nidn', $nidn)
                             ->whereIn('status_surat', [0, 5])
                             ->paginate(request('per_page') ?? 10)
                             ->appends(request()->query());

        } elseif ($role === 'kaprodi') {
            // Kaprodi melihat suratnya + yang status diajukan/diproses
            // $surat = SuratTugas::where('nidn', $nidn)
            //     ->orWhereIn('status_surat', ['diajukan', 'diproses'])
            //     ->get();

                $surat = SuratTugas::where('nidn', $nidn);
            // Data yang sedang diproses (kecuali ditolak dan ditandatangani)
            $dataTop = $surat->whereNotIn('status_surat', ['ditolak', 'ditandatangani'])
                             ->paginate(request('per_page') ?? 10)
                             ->appends(request()->query());

            // Clone query untuk bagian bottom (karena query sebelumnya sudah digunakan)
            $dataBottom = SuratTugas::where('nidn', $nidn)
                             ->whereIn('status_surat', ['ditolak', 'ditandatangani'])
                             ->paginate(request('per_page') ?? 10)
                             ->appends(request()->query());
            
            

        } elseif ($role === 'dekan') {
            // Dekan hanya melihat surat yang sudah disetujui kaprodi
            $surat = SuratTugas::where('status_surat', 'disetujui_kaprodi')->get();

        } else {
            abort(403, 'Role pengguna tidak dikenali.');
        }

        if ($role === 'admin') {
            return view('admin.riwayat_surat', compact('surat', 'dataBottom', 'dataTop'));
        } else if ($role ==="kaprodi"){
            return view('dosen_kaprodi.riwayat_surat', compact('surat', 'dataBottom', 'dataTop'));
        }else {
            return view('dosen_kaprodi.riwayat_surat', compact('surat', 'dataBottom', 'dataTop'));
        }
    }

    public function edit($id)
    {
        $surat = SuratTugas::findOrFail($id);

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

        // → hanya replace file jika upload baru
        if ($request->hasFile('lampiran')) {
            $fileName = time().'_'.$request->lampiran->getClientOriginalName();
            $request->lampiran->storeAs('lampiran', $fileName, 'public');
            $surat->lampiran = $fileName;
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
            ->with('success', 'Pengajuan surat tugas berhasil dikirim!');
    }
}
