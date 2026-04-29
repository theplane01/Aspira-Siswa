<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Admin;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function siswaProfile()
    {
        if(!session('siswa_nis')) {
            return redirect('/login');
        }
        
        $siswa = Siswa::findOrFail(session('siswa_nis'));
        $laporan_saya = \App\Models\Aspirasi::where('nis', session('siswa_nis'))
                        ->with('kategori')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
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

    public function laporanSaya()
    {
        if(!session('siswa_nis')) {
            return redirect('/login');
        }

        $laporan_saya = Aspirasi::where('nis', session('siswa_nis'))
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa_laporan', compact('laporan_saya'));
    }

    public function editLaporanSaya($id_pelaporan)
    {
        if(!session('siswa_nis')) {
            return redirect('/login');
        }

        $laporan = Aspirasi::where('id_pelaporan', $id_pelaporan)
            ->where('nis', session('siswa_nis'))
            ->firstOrFail();

        if ($laporan->status !== 'Menunggu') {
            return redirect('/laporan-saya')->with('error', 'Laporan yang sudah diproses tidak dapat diubah.');
        }

        $kategoris = Kategori::orderBy('ket_kategori')->get();

        return view('siswa_laporan_edit', compact('laporan', 'kategoris'));
    }

    public function updateLaporanSaya(Request $request, $id_pelaporan)
    {
        if(!session('siswa_nis')) {
            return redirect('/login');
        }

        $laporan = Aspirasi::where('id_pelaporan', $id_pelaporan)
            ->where('nis', session('siswa_nis'))
            ->firstOrFail();

        if ($laporan->status !== 'Menunggu') {
            return redirect('/laporan-saya')->with('error', 'Laporan yang sudah diproses tidak dapat diubah.');
        }

        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'lokasi' => 'required|string|max:50',
            'ket' => 'required|string|min:10|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'id_kategori.required' => 'Jenis laporan harus dipilih.',
            'id_kategori.exists' => 'Jenis laporan yang dipilih tidak valid.',
            'lokasi.required' => 'Lokasi peristiwa harus diisi.',
            'lokasi.max' => 'Lokasi maksimal 50 karakter.',
            'ket.required' => 'Penjelasan laporan harus diisi.',
            'ket.min' => 'Penjelasan laporan minimal 10 karakter.',
            'foto.image' => 'Lampiran harus berupa file gambar yang valid.',
            'foto.mimes' => 'Format gambar hanya boleh JPG, JPEG, PNG, atau GIF.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($laporan->foto && File::exists(public_path($laporan->foto))) {
                File::delete(public_path($laporan->foto));
            }

            $fotoFile = $request->file('foto');
            $folder = public_path('uploads/aspirasi');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $filename = time() . '_' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();
            $fotoFile->move($folder, $filename);
            $validated['foto'] = 'uploads/aspirasi/' . $filename;
        }

        $laporan->update($validated);

        return redirect('/laporan-saya')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function deleteLaporanSaya($id_pelaporan)
    {
        if(!session('siswa_nis')) {
            return redirect('/login');
        }

        $laporan = Aspirasi::where('id_pelaporan', $id_pelaporan)
            ->where('nis', session('siswa_nis'))
            ->firstOrFail();

        if ($laporan->status !== 'Menunggu') {
            return redirect('/laporan-saya')->with('error', 'Laporan yang sudah diproses tidak dapat dihapus.');
        }

        if ($laporan->foto && File::exists(public_path($laporan->foto))) {
            File::delete(public_path($laporan->foto));
        }

        $laporan->delete();

        return redirect('/laporan-saya')->with('success', 'Laporan berhasil dihapus.');
    }
}
