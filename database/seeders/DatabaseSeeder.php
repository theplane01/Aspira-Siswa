<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Admin::create([
            'username' => 'admin',
            'password' => bcrypt('123'), // Passwordnya 123, di-encrypt biar aman
            'nama_admin' => 'Admin Ganteng'
        ]);

        \App\Models\Siswa::create([
            'nis' => '12345',
            'nama' => 'Ucok Ganteng',
            'password' => bcrypt('siswa123'),
            'kelas' => 'XII-RPL' // <--- Tambahkan ini biar MySQL gak ngamuk lagi!
        ]);

    // Buat Kategori Sarana [cite: 75, 79]
    \App\Models\Kategori::create(['id_kategori' => 1, 'ket_kategori' => 'Sarana Kelas']);
    \App\Models\Kategori::create(['id_kategori' => 2, 'ket_kategori' => 'Fasilitas Olahraga']);
    \App\Models\Kategori::create(['id_kategori' => 3, 'ket_kategori' => 'Kebersihan']);
    }
}
