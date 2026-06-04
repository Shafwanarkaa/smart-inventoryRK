<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Tampilkan form ubah password
     */
    public function showUbahPassword()
    {
        return view('profil.ubah-password');
    }

    /**
     * Proses ubah password
     */
    public function ubahPassword(Request $request)
    {
        $request->validate([
            'password_lama'         => 'required|string',
            'password_baru'         => 'required|string|min:6|confirmed',
        ], [
            'password_lama.required'        => 'Password lama wajib diisi.',
            'password_baru.min'             => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed'       => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        // Cek apakah password lama benar
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.'])->withInput();
        }

        // Cek apakah password baru sama dengan password lama
        if (Hash::check($request->password_baru, $user->password)) {
            return back()->withErrors(['password_baru' => 'Password baru tidak boleh sama dengan password lama.'])->withInput();
        }

        $user->update(['password' => Hash::make($request->password_baru)]);

        return back()->with('success', 'Password berhasil diubah! Gunakan password baru untuk login berikutnya.');
    }
}
