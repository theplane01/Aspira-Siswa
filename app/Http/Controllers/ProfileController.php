<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function siswaProfile()
    {
        if(!session('siswa_nis')) {
            return redirect('/login');
        }
        
        $siswa = Siswa::findOrFail(session('siswa_nis'));
        $laporan_saya = \App\Models\Aspirasi::where('nis', session('siswa_nis'))->get();
        
        return view('siswa_profile', compact('siswa', 'laporan_saya'));
    }

    public function adminProfile()
    {
        if(!session('admin_id')) {
            return redirect('/login');
        }
        
        $admin = Admin::findOrFail(session('admin_id'));
        return view('admin_profile', compact('admin'));
    }

    public function updateSiswaProfile(Request $request)
    {
        if(!session('siswa_nis')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
        ]);

        $siswa = Siswa::findOrFail(session('siswa_nis'));
        $siswa->update($validated);
        
        session(['siswa_nama' => $validated['nama']]);
        return redirect('/profile')->with('success', 'Profil berhasil diupdate');
    }

    public function updateAdminProfile(Request $request)
    {
        if(!session('admin_id')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'nama_admin' => 'required|string|max:255',
        ]);

        $admin = Admin::findOrFail(session('admin_id'));
        $admin->update(['nama_admin' => $validated['nama_admin']]);
        
        session(['admin_nama' => $validated['nama_admin']]);
        return redirect('/admin/profile')->with('success', 'Profil berhasil diupdate');
    }
}
