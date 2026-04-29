<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;

class AspirasiDetailController extends Controller
{
    public function show($id_pelaporan)
    {
        $aspirasi = Aspirasi::with(['kategori'])->findOrFail($id_pelaporan);
        return view('aspirasi_detail', compact('aspirasi'));
    }
}

