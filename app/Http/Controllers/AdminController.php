<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Lecturer;
use App\Models\Permission;
use App\Models\Position;
use App\Models\PositionAssignment;
use App\Models\SuratTemplate;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'user'   => Lecturer::all()->count(),
            'permission'   => Permission::all()->count(),
            'surat_template'  => SuratTemplate::all()->count(),
        ];

        $query = LogAktivitas::join('lecturers', 'lecturers.nidn', '=', 'log_aktivitas.nidn')
            ->select('log_aktivitas.*', 'lecturers.full_name')
            ->orderBy('log_id', 'DESC');        
        $logs = $query->paginate(5);

        return view('admin.index', compact('stats', 'logs'));
    }

    // === USER MANAGEMENT ===
    public function users()
    {
        $users = Lecturer::with([
            'activePositionAssignment.position',
            'permissions'
        ])->get();

        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        $permissions = Permission::all();
        $positions   = Position::all();
        
        return view('admin.user_form', compact('permissions','positions'))->with('user', null);
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:lecturers,username',
            'email' => 'required|email|unique:lecturers,email',
            'nidn' => 'required|unique:lecturers,nidn',
            'lecturer_code' => 'nullable|unique:lecturers,lecturer_code',
            'full_name' => 'required',
            'password' => 'required|min:3',
            'role' => 'required|in:admin,sekretaris,kaprodi,dekan,rektor,bau,dosen',
            'employment_status' => 'required|in:active,inactive',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_certified' => 'boolean',

            // permissions
            'permissions' => 'nullable|array',

            // posisi HANYA 1
            'position_id' => 'required|exists:positions,position_id',
        ]);

        // Insert lecturer
        $lecturer = Lecturer::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'full_name' => $request->full_name,
            'lecturer_code' => $request->lecturer_code,
            'nidn' => $request->nidn,
            'employment_status' => $request->employment_status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_certified' => $request->is_certified ?? 0,
        ]);

        // Attach permissions (many-to-many)
        if($request->permissions){
            $lecturer->permissions()->attach($request->permissions);
        }

        // Position Assignment (1 posisi)
        PositionAssignment::create([
            'position_id' => $request->position_id,
            'nidn' => $request->nidn,
            'start_date' => $request->start_date ?? now(),
            'end_date' => $request->end_date ?? now()->addYears(1),
            'decree_number' => $request->decree_number ?? null,
            'assignment_status' => 1,
        ]);

        logAktivitas::create([
            'nidn'       => session('user.nidn'),
            'aktivitas'  => 'Membuat User Baru : '. $request->full_name,
            'module'     => 'Auth',
            'module_id'  => null,
            'keterangan' => 'Mengakses halaman tambah user baru',
        ]);

        return redirect()->route('admin.users')->with('success','User berhasil ditambahkan.');
    }

    public function editUser($id)
    {
        $user = Lecturer::with(['permissions', 'activePositionAssignment'])->findOrFail($id);
        $permissions = Permission::all();
        $positions = Position::all();

        return view('admin.user_form', compact('user', 'permissions', 'positions'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = Lecturer::findOrFail($id);

        $data = $request->validate([
            'username' => 'required|unique:lecturers,username,' .$id,
            'email' => 'required|email|unique:lecturers,email,' . $id,
            'nidn' => 'required|unique:lecturers,nidn,' .$id,
            'lecturer_code' => 'nullable|unique:lecturers,lecturer_code,' .$id,
            'full_name' => 'required',
            'password' => 'nullable|min:3',
            'role' => 'required|in:admin,sekretaris,kaprodi,dekan,rektor,bau,dosen',
            'employment_status' => 'required|in:active,inactive',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_certified' => 'boolean',
            'permissions' => 'nullable|array',
            'position_id' => 'required|exists:positions,position_id',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        // PERMISSIONS (sync agar update)
        if ($request->permissions) {
            $user->permissions()->sync($request->permissions);
        } else {
            $user->permissions()->sync([]); // kosongkan jika tidak memilih
        }

        // UPDATE / CREATE POSITION ASSIGNMENT
        $assignment = PositionAssignment::where('nidn', $user->nidn)->first();

        if ($assignment) {
            // Update existing assignment
            $assignment->update([
                'position_id' => $request->position_id,
                'start_date' => $request->start_date ?? $assignment->start_date,
                'end_date' => $request->end_date ?? $assignment->end_date,
                'decree_number' => $request->decree_number ?? $assignment->decree_number,
            ]);
        } else {
            // Create new assignment
            PositionAssignment::create([
                'position_id' => $request->position_id,
                'nidn' => $request->nidn,
                'start_date' => $request->start_date ?? now(),
                'end_date' => $request->end_date ?? now()->addYears(1),
                'decree_number' => $request->decree_number ?? null,
                'assignment_status' => 1,
            ]);
        }
        logAktivitas::create([
            'nidn'       => session('user.nidn'),
            'aktivitas'  => 'Memperbarui User : '. $request->full_name,
            'module'     => 'Auth',
            'module_id'  => $id,
            'keterangan' => 'Memperbarui data user dengan ID: ' . $id,
        ]);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser($id)
    {   
            logAktivitas::create([
                'nidn'       => session('user.nidn'),
                'aktivitas'  => 'Menghapus user',
                'module'     => 'Auth',
                'module_id'  => $id,
                'keterangan' => 'Menghapus user dengan ID: ' . $id,
            ]);
        Lecturer::destroy($id);
            
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    public function logAktivitas(Request $request)
    {
        $query = LogAktivitas::with('lecturer')->orderBy('log_id', 'DESC');
        $today = LogAktivitas::whereDate('created_at', Carbon::today())->count();
        $total = $query->count();

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('user')) {
            $query->whereHas('lecturer', function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->user . '%')
                ->orWhere('nidn', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('jenis')) {
            $query->where('aktivitas', 'like', '%' . $request->jenis . '%');
        }

        // 🔥 Pagination 20 item
        $logs = $query->paginate(20);

        return view('admin.logs', compact('logs', 'today', 'total'));
    }


}
