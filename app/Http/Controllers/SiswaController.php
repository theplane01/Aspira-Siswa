<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        if (!session('admin_id')) {
            return redirect('/login')->with('error', 'Anda harus login sebagai admin.');
        }

        $siswas = Siswa::withCount('aspirasis')->orderBy('created_at', 'desc')->get();
        return view('admin_siswa', compact('siswas'));
    }

    public function show($nis)
    {
        $siswa = Siswa::findOrFail($nis);
        return view('admin_siswa_detail', compact('siswa'));
    }

    public function update(Request $request, $nis)
    {
        if (!session('admin_id')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $siswa = Siswa::findOrFail($nis);
        $siswa->update($validated);
        return redirect('/admin/siswa')->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy($nis)
    {
        if (!session('admin_id')) {
            return redirect('/login');
        }

        $siswa = Siswa::findOrFail($nis);
        $siswa->delete();
        return redirect('/admin/siswa')->with('success', 'Siswa berhasil dihapus');
    }

    public function approve($nis)
    {
        if (!session('admin_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $siswa = Siswa::where('nis', $nis)->first();
        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => "Akun {$siswa->nama} berhasil disetujui."
        ]);
    }

    public function reject($nis)
    {
        if (!session('admin_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $siswa = Siswa::where('nis', $nis)->first();
        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => "Akun {$siswa->nama} berhasil ditolak."
        ]);
    }
}
