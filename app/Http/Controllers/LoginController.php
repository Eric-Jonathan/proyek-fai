<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
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
        // dd($request->all());
        // ============================================
        // 1. Ensure default admin exists
        // ============================================
        $admin = Lecturer::where('username', 'admin')->first();
        // dd($admin);

        if (!$admin) {
            Lecturer::create([
                'username' => 'admin',
                'password' => Hash::make('123'),
                'email' => 'admin@mail.com',

                // kolom relasi/role
                'role' => 'admin',
                'atasan_id' => null,

                // kolom dosen
                'full_name' => 'Administrator',
                'lecturer_code' => 'ADM001',
                'nidn' => '999999',
                'employment_status' => 'active',
                'is_certified' => 0,
            ]);
        }
        // 2. Ambil lecturer + load permission
        $user = Lecturer::with('permissions')->where('username', $request->username)->first();

        // 3. Validasi password
        if ($user && Hash::check($request->password, $user->password)) {

            // AMBIL PERMISSION DALAM BENTUK ARRAY STRING
            $permissionList = $user->permissions->pluck('permission_name')->toArray();
            // contoh hasil: ["create_surat", "view_dashboard", "approve_surat"]

            // SIMPAN SESSION
            Session::put('user', [
                'id'        => $user->id,
                'username'  => $user->username,
                'role'      => $user->role,
                'full_name' => $user->full_name,
                'nidn'      => $user->nidn,
                'atasan_id' => $user->atasan_id,
                'permissions' => $permissionList      // <= PERMISSION DISIMPAN
            ]);

            // ============================================
            // 4. Redirect berdasarkan role
            // ============================================
            // dd(Session::get('user'));
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
                default:
                    return redirect('/')->with('error', 'Hak akses tidak dikenali.');
            }
        }

        return redirect('/')->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}