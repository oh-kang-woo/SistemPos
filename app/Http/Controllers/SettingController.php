<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        // FIX: Ambil data setting khusus milik business_id user yang sedang login
        $businessId = Auth::user()->business_id;
        $setting = Setting::where('business_id', $businessId)->first();

        // Ambil data user yang terikat dengan bisnis yang sama saja
        $users = User::where('business_id', $businessId)->get();

        return view('setting.index', compact('setting', 'users'));
    }

    public function updateProfil(Request $request)
    {
        $businessId = Auth::user()->business_id;

        // FIX: Cari atau buat baru baris setting yang terikat dengan business_id user saat ini
        $setting = Setting::firstOrCreate(['business_id' => $businessId]);

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'nomor_telepon' => 'required',
            'nomor_whatsapp' => 'required',
            'logo_toko' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        $data = $request->only(['nama_toko', 'alamat_lengkap', 'nomor_telepon', 'nomor_whatsapp', 'npwp']);

        if ($request->hasFile('logo_toko')) {
            // Hapus logo lama di folder public jika ada
            if ($setting->logo_toko && file_exists(public_path($setting->logo_toko))) {
                unlink(public_path($setting->logo_toko));
            }

            $file = $request->file('logo_toko');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('logos'), $fileName);

            $data['logo_toko'] = 'logos/' . $fileName;
        }

        $setting->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profil toko berhasil diperbarui!',
                'nama_toko' => $setting->nama_toko,
                'alamat_lengkap' => $setting->alamat_lengkap
            ]);
        }

        return redirect()->back()->with('success', 'Profil toko berhasil diperbarui!');
    }

    public function updateStruk(Request $request)
    {
        $businessId = Auth::user()->business_id;

        // FIX: Ambil data struk sesuai milik business_id user saat ini
        $setting = Setting::firstOrCreate(['business_id' => $businessId]);

        $setting->update([
            'format_nomor_transaksi' => $request->format_nomor_transaksi,
            'reset_nomor_urut' => $request->reset_nomor_urut,
            'ukuran_kertas' => $request->ukuran_kertas,
            'margin' => $request->margin,
            'cetak_otomatis' => $request->has('cetak_otomatis') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Pengaturan struk & cetak berhasil diperbarui!');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        // FIX: Daftarkan user baru dengan business_id yang sama dengan sang pemilik akun saat ini
        User::create([
            'business_id' => Auth::user()->business_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }
}
