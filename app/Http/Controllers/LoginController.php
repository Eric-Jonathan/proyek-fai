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
        // pastikan admin default ada
        $admin = Lecturer::where('username', 'admin')->first();
        if (!$admin) {
            Lecturer::create([
                'username' => 'admin',
                'password' => Hash::make('123'),
                'email'    => 'admin@mail.com',
                'role'     => 'admin',

                'full_name' => 'Administrator Utama',
                'lecturer_code' => 'ADM001',
                'nidn' => '999999',
                'employment_status' => 'active',
                'is_certified' => 0,
            ]);
        }

        // ambil lecturer + permissions + jabatannya
        $user = Lecturer::with([
                'permissions',
                'activePositions.position'
            ])
            ->where('username', $request->username)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // ambil semua nama jabatan aktif
            $parentPosition = $user->activePositions
                            ->pluck('position.parent_position_id')
                            ->first();

            $jabatan = $user->activePositions()->first()?->position?->position_name;
            $jabatanId = $user->activePositions()->first()?->position?->position_id;

            // array nama permissions
            $permissionList = $user->permissions
                                ->pluck('permission_name')
                                ->toArray();

            // simpan ke session
            session([
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'full_name' => $user->full_name,
                    'nidn' => $user->nidn,
                    'jabatan' => $jabatan,
                    'jabatanId' => $jabatanId,
                    'email' => $user->email,
                    'role' => $user->role,
                    'permissions' => $permissionList,
                    'parent_position_id' => $parentPosition,
                ]
            ]);

            // dd( session('user'));

            // redirect role
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'sekretaris' => redirect()->route('sekretaris.dashboard'),
                'kaprodi' => redirect()->route('kaprodi.dashboard'),
                'dekan' => redirect()->route('dekan.dashboard'),
                'rektor' => redirect()->route('rektor.dashboard'),
                'bau' => redirect()->route('bau.dashboard'),
                'dosen' => redirect()->route('dosen.dashboard'),
                default => redirect('/')->with('error', 'Role tidak dikenali.'),
            };
        }

        return redirect('/')->with('error', 'Username atau password salah.');
    }


    public function logout()
    {
        Session::flush();
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
