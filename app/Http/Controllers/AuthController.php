<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Business; // Letakkan di paling atas controller

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/kasir');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Menampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }



    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'string', 'in:manajer,karyawan'],
            'business_name' => ['required', 'string', 'max:255'], // Validasi nama bisnis dari form html kamu
        ]);

        // 1. Buat Bisnis/Toko Baru
        $business = Business::create([
            'name' => $request->business_name
        ]);

        // 2. Buat User Manajer yang dikunci ke Bisnis tersebut
        $user = User::create([
            'business_id' => $business->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Berisi "manajer" sesuai input hidden form
        ]);

        Auth::login($user);

        return redirect('/kasir');
    }
    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showProfile()
{
    return view('auth.profile', [
        'user' => auth()->user()
    ]);
}

// Memproses update profil (No HP & Foto)
public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'phone_number' => ['required', 'string', 'max:15'],
        'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Maksimal 2MB
    ]);

    // Update Nomor HP
    $user->phone_number = $request->phone_number;

    // Proses Upload Foto jika ada file baru
    if ($request->hasFile('profile_photo')) {
        // Hapus foto lama jika ada dan bukan bawaan
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Simpan foto baru ke folder storage/app/public/profile_photos
        $path = $request->file('profile_photo')->store('profile_photos', 'public');
        $user->profile_photo = $path;
    }

    $user->save();

    return back()->with('success', 'Profil berhasil diperbarui!');
}
}
