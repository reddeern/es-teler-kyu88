<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        // Jika sudah login, jangan kasih masuk halaman login lagi, lempar ke produk
        if (Auth::check()) {
            return redirect()->route('produk.index');
        }
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // 2. Cari User berdasarkan username
        $user = User::where('username', $request->username)->first();

        // 3. Cek apakah user ada
        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan!')->withInput();
        }

        // 4. Cek apakah password cocok
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah!')->withInput();
        }

        // 5. Proses Login Manual
        try {
            Auth::login($user);

            // 6. Regenerate Session (PENTING: Menghindari serangan Session Fixation & Page Expired)
            $request->session()->regenerate();

            // 7. Redirect ke halaman produk sesuai keinginanmu
            return redirect()->route('produk.index');

        } catch (\Exception $e) {
            // Jika ada error sistem saat login
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}