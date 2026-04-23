<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin_kategori', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ket_kategori' => 'required|string|max:255',
        ]);

        Kategori::create($validated);
        return redirect('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ket_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);
        return redirect('/admin/kategori')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect('/admin/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
