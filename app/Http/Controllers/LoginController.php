<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    // 🔹 Pastikan ada user admin default
    $admin = DB::table('user')->where('username', 'admin')->first();
    if (!$admin) {
        DB::table('user')->insert([
            'username' => 'admin',
            'password' => Hash::make('NomMon123'),
            'hak_akses' => 'admin',
            'jabatan' => 'Administrator',
            'atasan_id' => null,
        ]);
    }

    // 🔹 Ambil user dari DB
    $user = DB::table('user')->where('username', $request->username)->first();

    // 🔹 Cek password
    if ($user && Hash::check($request->password, $user->password)) {
        Session::put('user', [
            'id' => $user->id,
            'username' => $user->username,
            'hak_akses' => $user->hak_akses,
            'jabatan' => $user->jabatan,
            'atasan_id' => $user->atasan_id,
        ]);

        switch ($user->hak_akses) {
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
    