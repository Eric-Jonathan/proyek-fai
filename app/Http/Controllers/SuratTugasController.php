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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Google_Client; // Pastikan ini ada di bagian atas file
use Google_Service_Drive; // Pastikan ini ada di bagian atas file

class SuratTugasController extends Controller
{
    public function surat($id)
    {
        $surat = SuratTugas::find($id);
        $lecturer = Lecturer::where('nidn', $surat->nidn)->first();

        // === GUARD CHECK: Hanya boleh dicetak jika statusnya 6 (Selesai) ===
        if (!$surat || $surat->status_surat != 6) {
            return redirect()->back()->with('error', 'Surat belum selesai dan tidak dapat dicetak.');
        }
        // ===================================================================

        // Panggil helper untuk membuat dan menyimpan PDF
        $storagePath = $this->generateAndStorePdf($surat);

        if (!$storagePath) {
            return back()->with('error', 'Gagal membuat file PDF. Cek log server.');
        }
        // PICU DOWNLOAD FILE YANG SUDAH TERSIMPAN
        $fileName = 'st ' . $lecturer->username . ' -- ' . $surat->jenis_tugas . '.pdf';
        return Storage::disk('public')->download($storagePath["storage_path"], $fileName);
    }

private function generateAndStorePdf(SuratTugas $surat)
    {
        // Set options terlebih dahulu, termasuk penanganan font untuk DomPDF
        Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultPaperSize' => 'a4',
            'defaultFont' => 'times',
        ]);

        // --- DATA FETCHING LOGIC (Sama seperti sebelumnya) ---
        $surat->load(['signedByPosition.parent']); 
        
        $lecturer = Lecturer::where('nidn', $surat->nidn)->first();

        $positionAssignment = PositionAssignment::where('nidn', $lecturer->nidn)
            ->with('position.parent') 
            ->first();
            
        $parent = $positionAssignment?->position?->parent;
        
        $parentAssignment = null;
        $atasan = null;

        if ($parent && $parent->parent_position_id) {
            $parentAssignment = PositionAssignment::where('position_id', $parent->parent_position_id)->first();
            if ($parentAssignment) {
                $atasan = Lecturer::where('nidn', $parentAssignment->nidn)->first();
            }
        }
        // -----------------------------------------

        // 1. GENERATE PDF DENGAN DomPDF
        $pdf = Pdf::loadView('CRUD_Surat.cetak_surat', [
            'surat' => $surat,
            'lecturer' => $lecturer,
            'parentAssignment' => $parentAssignment, 
            'user' => session('user'), 
            'atasan' => $atasan
        ]);

        // 2. TENTUKAN NAMA FILE DAN PATH PENYIMPANAN
        $fileName = 'st ' . $lecturer->username . ' -- ' . $surat->jenis_tugas . '.pdf';
        $storagePath = 'surat_tugas/final/' . $fileName; 

        // 3. SIMPAN FILE KE LARAVEL STORAGE (DISK 'PUBLIC')
        try {
            Storage::disk('public')->put($storagePath, $pdf->output());

            // Tentukan path absolut untuk upload ke Google Drive
            $absolutePath = storage_path('app/public/' . $storagePath);
            
            return ['storage_path' => $storagePath, 'absolute_path' => $absolutePath];
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan PDF ' . $fileName . ': ' . $e->getMessage());
            return null;
        }
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

        if ($parent->position_id == 1){
            $parentAssignment = PositionAssignment::where('position_id', $parent->position_id)->first();
            $atasan = Lecturer::where('nidn', $parentAssignment->nidn)->first();
        } else {
            $parentAssignment = PositionAssignment::where('position_id', $parent->parent_position_id)->first();
            $atasan = Lecturer::where('nidn', $parentAssignment->nidn)->first();
        }

        return view('CRUD_Surat.preview_pdf', [
            'surat' => $surat,
            'lecturer' => $lecturer,
            'parentAssignment' => $parentAssignment,
            'user' => $user,
            'atasan' => $atasan
        ]);
    }

    public function preview_storage($id)
    {
        $surat = SuratTugas::findOrFail($id);

        $lecturer = Lecturer::where('nidn', $surat->nidn)->first();

        $positionAssignment = PositionAssignment::where('nidn', $lecturer->nidn)
            ->with('position.parent')
            ->first();

        $parent = $positionAssignment?->position?->parent;

        $parentAssignment = PositionAssignment::where(
            'position_id',
            $parent?->parent_position_id
        )->first();

        $atasan = Lecturer::where('nidn', $parentAssignment?->nidn)->first();

        Pdf::setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultPaperSize' => 'a4',
            'defaultFont' => 'times',
        ]);

        // 1️⃣ Generate PDF
        $pdf = Pdf::loadView('CRUD_Surat.cetak_surat', [
            'surat' => $surat,
            'lecturer' => $lecturer,
            'parentAssignment' => $parentAssignment,
            'atasan' => $atasan,
        ])->setPaper('A4', 'portrait');

        // 2️⃣ Tentukan path storage
        $fileName = 'st ' . $lecturer->username . ' -- ' . $surat->jenis_tugas . '.pdf';
        $storagePath = 'preview/' . $fileName;

        // 3️⃣ Simpan ke storage/public
        Storage::disk('public')->put($storagePath, $pdf->output());

        // 5️⃣ Redirect ke file PDF (inline)
        return response()->file(storage_path('app/public/' . $storagePath));
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
            if(session('user')['role'] == "dekan" && $validated['sifat_surat'] == 'Non-Dinas'){
                $status = 6;
            } elseif (session('user')['role'] == "kaprodi" && $validated['sifat_surat'] == 'Non-Dinas') {
                $status = 3;
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

    // public function index(Request $request)
    // {
    //     /* ================================
    //      * TABEL ATAS (status: diajukan/diproses)
    //      * ================================ */
    //     $perPageTop = $request->input('per_page_top', 10);

    //     $queryTop = SuratTugas::from('surat_tugas AS st')
    //         ->select(
    //             'st.*',
    //             'l.full_name',
    //             'l.lecturer_code',
    //             'p.position_name',
    //             'p.bureau_name'
    //         )
    //         ->join('lecturers AS l', 'st.nidn', '=', 'l.nidn')
    //         ->leftJoin('position_assignments AS pa', function ($join) {
    //             $join->on('l.nidn', '=', 'pa.nidn')
    //                  ->where('pa.assignment_status', 1);
    //         })
    //         ->leftJoin('positions AS p', 'pa.position_id', '=', 'p.position_id')
    //         ->whereIn('st.status_surat', ['diajukan', 'diproses']);

    //     // Search tabel atas
    //     if ($request->filled('search_top')) {
    //         $search = $request->search_top;

    //         $queryTop->where(function ($q) use ($search) {
    //             $q->where('st.nama_kegiatan', 'like', "%{$search}%")
    //               ->orWhere('l.full_name', 'like', "%{$search}%")
    //               ->orWhere('p.position_name', 'like', "%{$search}%");
    //         });
    //     }

    //     $dataTop = $queryTop
    //     ->distinct('st.surat_id')
    //         ->orderBy('st.created_at', 'desc')
    //         ->paginate($perPageTop, ['*'], 'page_top');

    //     $dataTop->setCollection(
    //     $dataTop->getCollection()->unique('surat_id')->values()
    //     );


    //     /* ================================
    //      * TABEL BAWAH (semua riwayat)
    //      * ================================ */
    //     $perPageBottom = $request->input('per_page_bottom', 10);

    //     $queryBottom = SuratTugas::from('surat_tugas AS st')
    //         ->select(
    //             'st.*',
    //             'l.full_name',
    //             'l.lecturer_code',
    //             'p.position_name',
    //             'p.bureau_name'
    //         )
    //         ->join('lecturers AS l', 'st.nidn', '=', 'l.nidn')
    //         ->leftJoin('position_assignments AS pa', function ($join) {
    //             $join->on('l.nidn', '=', 'pa.nidn')
    //                  ->where('pa.assignment_status', 1);
    //         })
    //         ->leftJoin('positions AS p', 'pa.position_id', '=', 'p.position_id');

    //     // Search tabel bawah
    //     if ($request->filled('search_bottom')) {
    //         $search = $request->search_bottom;

    //         $queryBottom->where(function ($q) use ($search) {
    //             $q->where('st.nama_kegiatan', 'like', "%{$search}%")
    //               ->orWhere('l.full_name', 'like', "%{$search}%")
    //               ->orWhere('p.position_name', 'like', "%{$search}%");
    //         });
    //     }

    //     $dataBottom = $queryBottom
    //     ->distinct('st.surat_id')
    //         ->orderBy('st.created_at', 'desc')
    //         ->paginate($perPageBottom, ['*'], 'page_bottom');

    //     $dataBottom->setCollection(
    //     $dataBottom->getCollection()->unique('surat_id')->values()
    //     );


    //     return view('dashboard.index', compact('dataTop', 'dataBottom'));
    // }

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
    

public function acc(Request $request, $id)
{
    $surat = SuratTugas::findOrFail($id);

    $nidn       = session('user')['nidn'] ?? null;
    $role       = session('user')['role'] ?? null;
    $actionType = $request->input('action_type');

    $lecturer = Lecturer::where('nidn', $surat->nidn)->first();
    $xrole = $lecturer->role ?? null;

    $parentId = Position::where('position_id', session('user')['jabatanId'])
        ->value('parent_position_id');

    $statusLabels = [
        -1 => 'delete', 0 => 'ditolak', 1 => 'diajukan', 2 => 'disetujui_kaprodi',
        3 => 'diproses_sekretaris', 4 => 'disetujui_dekan', 5 => 'menunggu_stempel', 6 => 'selesai',
    ];

    $nextStatus = $surat->status_surat;
    $message = 'Surat berhasil disetujui!';
    $tt= $surat->signed_by_position_id;

    /* =====================================================
      | BLOK 1: LOGIKA FINALISASI (KHUSUS BAU) - HANYA STEMPEL
      ===================================================== */
    if ($role === 'bau' && $actionType === 'stempel' && in_array($surat->status_surat, [4, 5])) {

            try {
                // 1️⃣ UPDATE STATUS & STEMPEL
                $surat->status_surat = 6;
                $surat->stempel_path = 'asset/stempel.png';
                $surat->save(); 
                
                // 2️⃣ GENERATE & SIMPAN PDF AKHIR KE STORAGE
                $pdfPaths = $this->generateAndStorePdf($surat); 

                // 3️⃣ UPLOAD KE GOOGLE DRIVE
                $driveResult = false;
                $driveStatus = 'Gagal diupload ke Drive.';
                
                if ($pdfPaths) {
                    $fileName = basename($pdfPaths['storage_path']); 
                    $driveResult = $this->uploadToGoogleDrive($pdfPaths['absolute_path'], $fileName);
                    
                    if ($driveResult) {
                         // 4️⃣ Update path PDF & Drive di database
                        $surat->pdf_path = $pdfPaths['storage_path']; // Path lokal
                        $surat->drive_file_id = $driveResult['id']; // ID Google Drive
                        $surat->drive_link = $driveResult['link']; // Link Google Drive
                        $surat->save();
                        $driveStatus = 'Berhasil diupload ke Drive. Link: ' . $driveResult['link'];
                    } else {
                        // Jika upload gagal, setidaknya simpan path lokal
                        $surat->pdf_path = $pdfPaths['storage_path'];
                        $surat->save();
                    }
                }

                // 5️⃣ LOG AKTIVITAS
                LogAktivitas::create([
                    'nidn' => $nidn,
                    'aktivitas' => 'Surat Tugas Final',
                    'module' => 'Surat_Tugas',
                    'module_id' => $id,
                    'keterangan' => 'Surat distempel BAU, status Selesai (6). File PDF final disimpan di storage. ' . $driveStatus,
                ]);

                return redirect()
                    ->route(session('user.role') . '.dashboard')
                    ->with('success', 'Surat berhasil difinalisasi! File PDF telah disimpan di Storage dan ' . ($driveResult ? '**diupload ke Google Drive**.' : '**Gagal diupload ke Google Drive (tersimpan lokal)**.'));

            } catch (\Throwable $e) {
                Log::error('BAU STEMPEL FAILED', [
                    'surat_id' => $id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return back()->with('error', 'Gagal menstempel surat: ' . $e->getMessage());
            }
        }
    
    // ... (BLOK 2: TANDA TANGAN DIGITAL (KHUSUS DEKAN) dan BLOK 3: LOGIKA STATUS SURAT (UMUM) tidak diubah)

    if ($role === 'dekan' && $surat->status_surat == 3) {
        $request->validate(['ttd_base64' => 'required|string']);
        $base64Image = $request->ttd_base64; 
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
        }
        $base64Image = base64_decode($base64Image);
        $filename = 'ttd_dekan_' . time() . '.png';
        $path = 'ttd_dekan/' . $filename;
        Storage::disk('public')->put($path, $base64Image);

        $surat->ttd_dekan = $path;
        $nextStatus = 5;
        $message = 'Surat berhasil disetujui dan ditandatangani Dekan.';
    }


    
    if ($role !== 'bau' || $actionType !== 'stempel') {
        
        if ($role === 'dekan' && $surat->status_surat == 3) {
        // ...
        }
        elseif ($surat->status_surat == 3 && $role != 'dekan') {
            $nextStatus = 5; 
        } 
        elseif ($surat->status_surat == 4) {
            $nextStatus = 5; 
        } 
        elseif ($surat->signed_by_position_id == 1) {
            $nextStatus = 4; 
        } 
        elseif ($parentId != null) { 
            $surat->signed_by_position_id = $parentId;
            $nextStatus += 1; 
        } else {
            $nextStatus += 1; 
        }
        
        if ($surat->sifat == 'Non-Dinas'){
            if ($role == 'kaprodi' && $nextStatus == 2) {
                $message = 'Surat Non-Dinas selesai diproses Kaprodi.';
            } else {
                $message = 'Surat Non-Dinas selesai diproses Dekan.';
            }
            $nextStatus = 6; 
        }
        
        $surat->status_surat = $nextStatus;
        $surat->save();
    }

    /* =====================================================
      | LOG AKTIVITAS 
      ===================================================== */
    if (!($role === 'bau' && $actionType === 'stempel')) {
        LogAktivitas::create([
            'nidn' => $nidn,
            'aktivitas' => 'Surat Tugas ' . ($statusLabels[$surat->status_surat] ?? 'Proses'),
            'module' => 'Surat_Tugas',
            'module_id' => $id,
            'keterangan' => 'Surat ID ' . $id . ' di-ACC oleh ' . $role,
        ]);
    }

    return redirect()
        ->route(session('user.role') . '.dashboard')
        ->with('success', $message);
}

// private function generateAndUploadPdfToDrive($surat)
// {
//     Pdf::setOptions([
//         'isRemoteEnabled' => true,
//         'isHtml5ParserEnabled' => true,
//     ]);

//     // === AMBIL DATA SAMA PERSIS DENGAN CETAK ===
//     $lecturer = Lecturer::where('nidn', $surat->nidn)->first();

//     $positionAssignment = PositionAssignment::where('nidn', $lecturer->nidn)
//         ->with('position.parent')
//         ->first();

//     $parent = $positionAssignment?->position?->parent;

//     $parentAssignment = PositionAssignment::where(
//         'position_id',
//         $parent?->parent_position_id
//     )->first();

//     $atasan = Lecturer::where('nidn', $parentAssignment?->nidn)->first();

//     // === GENERATE PDF ===
//     $pdf = Pdf::loadView('CRUD_Surat.cetak_surat', [
//         'surat' => $surat,
//         'lecturer' => $lecturer,
//         'parentAssignment' => $parentAssignment,
//         'atasan' => $atasan,
//         'user' => null,
//     ])->setPaper('A4', 'portrait');

//     // === SIMPAN KE STORAGE ===
//     $fileName = 'Surat_Tugas_' . str_replace('/', '_', $surat->nomor_surat) . '.pdf';
//     $localPath = 'surat_tugas/' . $fileName;

//     Storage::disk('public')->put($localPath, $pdf->output());

//     // === UPLOAD KE DRIVE ===
//     $drive = $this->uploadToGoogleDrive(
//         storage_path('app/public/' . $localPath),
//         $fileName
//     );

//     return [
//         'pdf_path' => $localPath,
//         'drive_file_id' => $drive['id'],
//         'drive_link' => $drive['link'],
//     ];
// }


private function uploadToGoogleDrive($filePath, $fileName)
{
    // ... (Guard checks untuk file path dan file name)

    try {
        $client = new Google_Client();
        
        // 1. SET KREDENSIAL OAUTH BARU
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        
        $refreshToken = env('GOOGLE_REFRESH_TOKEN');

        if (!$refreshToken) {
            // Log error jika token belum diset
            Log::error('Upload Drive Gagal: GOOGLE_REFRESH_TOKEN tidak ditemukan di .env.');
            return false;
        }

        // 2. TUKAR REFRESH TOKEN DENGAN ACCESS TOKEN BARU
        // Google Client akan secara otomatis mendapatkan Access Token yang sah.
        $client->fetchAccessTokenWithRefreshToken($refreshToken); 

        // 3. Gunakan Access Token yang baru
        $accessToken = $client->getAccessToken(); 
        $client->setAccessToken($accessToken);
        
        // 4. Inisialisasi Service Drive
        $service = new Google_Service_Drive($client);

        // Metadata file
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [env('GOOGLE_DRIVE_FOLDER_ID')], // ID Folder My Drive Anda
        ]);

        $content = file_get_contents($filePath);

        // 5. Lakukan Proses Upload
        $file = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/pdf',
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink'
            
            // 🔥 HILANGKAN supportsAllDrives => Karena kita upload ke My Drive pribadi
        ]);

        return [
            'id'   => $file->id,
            'link' => $file->webViewLink,
        ];
        
    } catch (\Throwable $e) {
        // Log error jika ada kegagalan
        Log::error('Gagal mengupload ke Google Drive (OAuth Error): ' . $e->getMessage(), [
            'file' => $fileName,
            'trace' => $e->getTraceAsString(),
        ]);
        return false;
    }
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
