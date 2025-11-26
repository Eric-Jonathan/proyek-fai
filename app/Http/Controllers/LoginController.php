<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\PositionAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // ============================================
        // 1. Ensure default admin exists
        // ============================================
        $admin = Lecturer::where('username', 'admin')->first();

        if (!$admin) {
            Lecturer::create([
                'username' => 'admin',
                'password' => Hash::make('123'),
                'email'    => 'admin@mail.com',
                'role'     => 'admin',

                // kolom dosen
                'full_name'      => 'Administrator Utama',
                'lecturer_code'  => 'ADM001',
                'nidn'           => '999999',
                'employment_status' => 'active',
                'is_certified'   => 0,
            ]);
        }

        // ============================================
        // 2. Ambil lecturer beserta permissions
        // ============================================
        $user = Lecturer::with('permissions')
                ->where('username', $request->username)
                ->first();

        // ============================================
        // 3. Validasi password
        // ============================================
        if ($user && Hash::check($request->password, $user->password)) {
            $jabatan = PositionAssignment::with('position')
                ->where('nidn', $user->nidn)
                ->where('assignment_status', 1)
                ->get()
                ->pluck('position.position_name')   // ambil hanya nama jabatan
                ->toArray();

            // Semua permissions user (string array)
            $permissionList = $user->permissions->pluck('permission_name')->toArray();

            // ============================================
            // 4. Simpan ke SESSION
            // ============================================
            session([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'full_name' => $user->full_name,
                    'nidn' => $user->nidn,
                    'jabatan' => $jabatan,
                    'email' => $user->email,
                    'role' => $user->role,
                    'permissions' => $permissionList,
                ]
            ]);

            // ============================================
            // 5. Redirect berdasarkan role
            // ============================================
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'sekretaris':
                    return redirect()->route('sekretaris.dashboard');
                case 'kaprodi':
                    return redirect()->route('kaprodi.dashboard');
                case 'rektor':
                    return redirect()->route('rektor.dashboard');
                case 'bau':
                    return redirect()->route('bau.dashboard');
                case 'dosen':
                    return redirect()->route('dosen.dashboard');
                default:
                    return redirect('/')->with('error', 'Role tidak dikenali.');
            }
        }

        // ============================================
        // Jika gagal login
        // ============================================
        return redirect('/')->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
