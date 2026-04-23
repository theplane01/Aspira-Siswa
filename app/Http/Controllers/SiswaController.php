<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::all();
        return view('admin_siswa', compact('siswas'));
    }

    public function show($nis)
    {
        $siswa = Siswa::findOrFail($nis);
        return view('admin_siswa_detail', compact('siswa'));
    }

    public function update(Request $request, $nis)
    {
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
        $siswa = Siswa::findOrFail($nis);
        $siswa->delete();
        return redirect('/admin/siswa')->with('success', 'Siswa berhasil dihapus');
    }
}
