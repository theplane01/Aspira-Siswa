<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Siswa;

class AuthController extends Controller {
    public function showLogin() {
        // Kalau sudah ada session, gak usah login lagi, Wak!
        if (session('admin_id')) {
            return redirect('/admin');
        }
        if (session('siswa_nis')) {
            return redirect('/aspirasi');
        }
        return view('login');
    }

    public function login(Request $request) {
        $admin = Admin::where('username', $request->username)->first();

        // Cek username dan password manual karena kita pake tabel custom
        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_id' => $admin->id_admin, 'admin_nama' => $admin->nama_admin]);
            return redirect('/admin')->with('success', 'Selamat datang, ' . $admin->nama_admin . '. Anda telah berhasil login ke panel pengelola.');
        }

        return back()->with('error', 'Username atau kata sandi yang Anda masukkan tidak sesuai.');
    }

    public function logout(Request $request) {
        // Sapu bersih semua session
        session()->flush(); 
        
        // Atau kalau mau satu-satu:
        // session()->forget(['admin_id', 'admin_nama', 'siswa_nis', 'siswa_nama', 'role']);
    
        return redirect('/')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    public function loginSiswa(Request $request) {
        $siswa = Siswa::where('nis', $request->nis)->first();
    
        // Cek NIS dan Password (asumsi password di database sudah di-bcrypt)
        if ($siswa && Hash::check($request->password, $siswa->password)) {
            // Cek apakah status sudah approved
            if ($siswa->status !== 'approved') {
                return back()->with('error', 'Akun Anda belum disetujui oleh admin. Silakan tunggu konfirmasi.');
            }
            
            // Hapus session admin kalau ada (Biar gak bentrok)
            session()->forget(['admin_id', 'admin_nama']);
            
            session([
                'siswa_nis' => $siswa->nis,
                'siswa_nama' => $siswa->nama,
                'role' => 'siswa'
            ]);
            return redirect('/aspirasi')->with('success', 'Selamat datang, ' . $siswa->nama . '. Anda dapat mulai mengajukan laporan.');
        }
    
        return back()->with('error', 'NIS atau kata sandi yang Anda masukkan tidak sesuai.');
    }

    public function showRegister() {
        if (session('siswa_nis')) {
            return redirect('/aspirasi');
        }
        if (session('admin_id')) {
            return redirect('/admin');
        }

        return view('register');
    }

    public function registerSiswa(Request $request) {
        $request->validate([
            'nis' => 'required|numeric|digits_between:1,10|unique:siswas,nis',
            'nama' => 'required|string|max:35',
            'kelas' => 'required|string|max:10',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nis.required' => 'Nomor Induk Siswa (NIS) harus diisi.',
            'nis.unique' => 'Nomor Induk Siswa (NIS) ini sudah terdaftar.',
            'nis.numeric' => 'Nomor Induk Siswa (NIS) harus berupa angka.',
            'nama.required' => 'Nama lengkap harus diisi.',
            'nama.string' => 'Nama lengkap harus berupa teks.',
            'nama.max' => 'Nama lengkap maksimal 35 karakter.',
            'kelas.required' => 'Tingkat dan rombel harus diisi.',
            'kelas.string' => 'Tingkat dan rombel harus berupa teks.',
            'kelas.max' => 'Tingkat dan rombel maksimal 10 karakter.',
            'password.required' => 'Kata sandi harus diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
            'status' => 'pending', // Set status default ke pending
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan tunggu admin menyetujui akun Anda sebelum login.');
    }
}
