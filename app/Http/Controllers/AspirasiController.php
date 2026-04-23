<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index() 
    {
        $kategoris = Kategori::all();
        $status = request('status');

        if (session('admin_id')) {
            $aspirasisQuery = Aspirasi::with('kategori')
                ->orderBy('created_at', 'desc');

            $stats = [
                'total' => $aspirasisQuery->count(),
                'menunggu' => (clone $aspirasisQuery)->where('status', 'Menunggu')->count(),
                'proses' => (clone $aspirasisQuery)->where('status', 'Proses')->count(),
                'selesai' => (clone $aspirasisQuery)->where('status', 'Selesai')->count(),
            ];

            if (in_array($status, ['Menunggu', 'Proses', 'Selesai'])) {
                $aspirasisQuery->where('status', $status);
            }

            $aspirasis = $aspirasisQuery->get();

            return view('aspirasi', compact('kategoris', 'aspirasis', 'status', 'stats'));
        }

        if (!session('siswa_nis')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu untuk melihat laporan Anda.');
        }

        $aspirasisQuery = Aspirasi::where('nis', session('siswa_nis'))
                        ->with('kategori')
                        ->orderBy('created_at', 'desc');

        $stats = [
            'total' => $aspirasisQuery->count(),
            'menunggu' => (clone $aspirasisQuery)->where('status', 'Menunggu')->count(),
            'proses' => (clone $aspirasisQuery)->where('status', 'Proses')->count(),
            'selesai' => (clone $aspirasisQuery)->where('status', 'Selesai')->count(),
        ];

        $aspirasis = $aspirasisQuery->get();

        return view('aspirasi', compact('kategoris', 'aspirasis', 'stats'));
    }

    public function stats()
    {
        if (session('admin_id')) {
            $scope = Aspirasi::query();
        } elseif (session('siswa_nis')) {
            $scope = Aspirasi::where('nis', session('siswa_nis'));
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'total' => $scope->count(),
            'menunggu' => (clone $scope)->where('status', 'Menunggu')->count(),
            'proses' => (clone $scope)->where('status', 'Proses')->count(),
            'selesai' => (clone $scope)->where('status', 'Selesai')->count(),
        ]);
    }

    public function profile() {
        // 1. Cek dulu, kalau belum login tendang ke login
        if (!session('siswa_nis')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        // 2. Ambil data siswa dari tabel siswas
        $user = \App\Models\Siswa::where('nis', session('siswa_nis'))->first();
    
        // 3. Ambil laporan KHUSUS milik dia aja
        $laporan_saya = Aspirasi::where('nis', session('siswa_nis'))
                        ->with('kategori')
                        ->orderBy('created_at', 'desc')
                        ->get();
    
        return view('siswa_profile', compact('user', 'laporan_saya'));
    }

    

    public function store(Request $request) 
{
        // Lapis 1: Validasi Format Data
        $request->validate([
            'nis'         => 'required|numeric|digits_between:5,10', // NIS harus angka & panjangnya pas
            'id_kategori' => 'required|exists:kategoris,id_kategori', // Kategori harus ada di database
            'lokasi'      => 'required|max:50',
            'ket'         => 'required|min:10', // Biar nggak cuma isi "asdasd"
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Pesan error dalam bahasa Indonesia formal
            'nis.required' => 'Nomor Induk Siswa (NIS) harus diisi.',
            'nis.numeric' => 'Nomor Induk Siswa (NIS) harus berupa angka.',
            'nis.digits_between' => 'Nomor Induk Siswa (NIS) harus terdiri dari 5-10 digit.',
            'id_kategori.required' => 'Jenis laporan harus dipilih.',
            'id_kategori.exists' => 'Jenis laporan yang dipilih tidak valid.',
            'lokasi.required' => 'Lokasi peristiwa harus diisi.',
            'lokasi.max' => 'Lokasi maksimal 50 karakter.',
            'ket.required' => 'Penjelasan laporan harus diisi.',
            'ket.min' => 'Penjelasan laporan minimal 10 karakter agar detail dan mudah dipahami.',
            'foto.image' => 'Lampiran harus berupa file gambar yang valid.',
            'foto.mimes' => 'Format gambar hanya boleh JPG, JPEG, PNG, atau GIF.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Lapis 2: Validasi Anti-Spam (Pencegahan)
        $cekSpam = Aspirasi::where('nis', $request->nis)
                    ->whereDate('created_at', date('Y-m-d')) // Cek laporan di hari yang sama
                    ->count();

        if ($cekSpam >= 2) { // Kita kasih jatah maksimal 2 laporan per hari biar gak pelit kali
            return redirect()->back()->withErrors(['spam' => 'Anda telah mencapai batas pelaporan untuk hari ini. Silakan coba lagi besok atau tunggu respons dari admin.']);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoFile = $request->file('foto');
            $folder = public_path('uploads/aspirasi');

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $filename = time() . '_' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();
            $fotoFile->move($folder, $filename);
            $fotoPath = 'uploads/aspirasi/' . $filename;
        }

        // Kalau lolos dua lapis tadi, baru kita simpan
        Aspirasi::create([
            'nis'         => $request->nis,
            'id_kategori' => $request->id_kategori,
            'lokasi'      => $request->lokasi,
            'ket'         => $request->ket,
            'status'      => 'Menunggu', // Status awal default
            'foto'        => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Laporan Anda telah berhasil dikirim dan menunggu verifikasi dari admin.');
    }

    public function publicAspirations()
    {
        $aspirasis = Aspirasi::with('kategori')
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);

        return view('aspirasi_publik', compact('aspirasis'));
    }
}