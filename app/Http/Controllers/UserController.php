<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Daftar semua user
     */
    public function index()
    {
        $users = User::orderByRaw("FIELD(role, 'super_admin', 'manajer', 'koki', 'staff')")->get();

        return view('manajer.users.index', compact('users'));
    }

    /**
     * Form tambah user baru
     */
    public function create()
    {
        return view('manajer.users.create');
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:super_admin,manajer,koki,staff',
        ], [
            'username.unique'    => 'Username sudah dipakai, pilih yang lain.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('manajer.users.index')
            ->with('success', "User '{$request->username}' berhasil ditambahkan.");
    }

    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        return view('manajer.users.edit', compact('user'));
    }

    /**
     * Update data user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'role'     => 'required|in:super_admin,manajer,koki,staff',
        ], [
            'username.unique'    => 'Username sudah dipakai user lain.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'username' => $request->username,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('manajer.users.index')
            ->with('success', "User '{$user->username}' berhasil diperbarui.");
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun yang sedang aktif.');
        }

        $nama = $user->username;
        $user->delete();

        return redirect()->route('manajer.users.index')
            ->with('success', "User '{$nama}' berhasil dihapus.");
    }
}
