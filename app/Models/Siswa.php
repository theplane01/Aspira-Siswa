<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas'; // Nama tabel kau
    protected $primaryKey = 'nis'; // NIS sebagai kunci utama
    public $incrementing = false; // Karena NIS bukan angka urut otomatis (Auto Increment)
    protected $keyType = 'string'; // Karena NIS kita anggap string/varchar

    protected $fillable = ['nis', 'nama', 'password', 'kelas', 'status']; // Tambahkan 'status' di sini!

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'nis', 'nis');
    }
}