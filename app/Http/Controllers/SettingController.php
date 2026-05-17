<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil baris pertama dari pengaturan
        $setting = Setting::first() ?? new Setting();
        $users = User::all();

        return view('setting.index', compact('setting', 'users'));
    }

    public function updateProfil(Request $request)
    {
        $setting = Setting::firstOrCreate([]);

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
            // Buat nama file unik agar tidak bentrok
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Pindahkan langsung ke folder public/logos
            $file->move(public_path('logos'), $fileName);

            // Simpan jalur relatifnya ke database (contoh: logos/12345_logo.png)
            $data['logo_toko'] = 'logos/' . $fileName;
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'Profil toko berhasil diperbarui!');
    }

    public function updateStruk(Request $request)
    {
        $setting = Setting::firstOrCreate([]);

        $setting->update([
            'format_nomor_transaksi' => $request->format_nomor_transaksi,
            'reset_nomor_urut' => $request->reset_nomor_urut,
            'ukuran_kertas' => $request->ukuran_kertas,
            'margin' => $request->margin,
            'cetak_otomatis' => $request->has('cetak_otomatis') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Pengaturan struk & cetak berhasil diperbarui!');
    }
}
