<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index');
    }

    // === USER MANAGEMENT ===
    public function users()
    {
        $users = Lecturer::all();
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.user_form', ['user' => null]);
    }

    public function storeUser(Request $request)
{
    $request->validate([
        'username' => 'required|unique:user,username',
        'email' => 'required|email|unique:user,email',
        'nidn' => 'required|unique:user,nidn',
        'password' => 'required|min:4',
        'jabatan' => 'nullable|string',
        'atasan_id' => 'nullable|integer|exists:user,id',
        'hak_akses' => 'required',
    ]);

    Lecturer::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'nidn' => $request->nidn,
        'role' => $request->jabatan,

    ]);

    return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
}


    public function editUser($id)
    {
        $user = Lecturer::findOrFail($id);
        return view('admin.user_form', compact('user'));
    }

    public function updateUser(Request $request, $id)
{
    $user = Lecturer::findOrFail($id);

    $data = $request->validate([
        'username' => 'required',
        'email' => 'required|email|unique:user,email,' . $id,
        'jabatan' => 'nullable|string',
        'hak_akses' => 'required|string',
        'atasan_id' => 'nullable|integer|exists:user,id',
    ]);

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
}

    public function deleteUser($id)
    {
        Lecturer::destroy($id);
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }


   public function logAktivitas(Request $request)
{
    $query = LogAktivitas::with('lecturer')->orderBy('log_id', 'DESC');

    if ($request->filled('tanggal')) {
        $query->whereDate('created_at', $request->tanggal);
    }

    if ($request->filled('user')) {
        $query->whereHas('lecturer', function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->user . '%')
              ->orWhere('nidn', 'like', '%' . $request->user . '%');
        });
    }

    if ($request->filled('jenis')) {
        $query->where('aktivitas', 'like', '%' . $request->jenis . '%');
    }

    // 🔥 Pagination 20 item
    $logs = $query->paginate(20);

    return view('admin.logs', compact('logs'));
}

}
