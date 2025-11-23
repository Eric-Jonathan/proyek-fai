<?php

namespace App\Http\Controllers;

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
        $users = User::all();
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

    User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'nidn' => $request->nidn,
        'jabatan' => $request->jabatan,
        'atasan_id' => $request->atasan_id,
        'hak_akses' => $request->hak_akses,
    ]);

    return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
}


    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user_form', compact('user'));
    }

    public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

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
        User::destroy($id);
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }
}
