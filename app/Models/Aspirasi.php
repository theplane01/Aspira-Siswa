<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasis'; 
    protected $primaryKey = 'id_pelaporan'; 
    public $incrementing = false; 

    protected $fillable = [
        'id_pelaporan', 
        'nis', 
        'id_kategori', 
        'lokasi', 
        'ket', 
        'status', 
        'feedback', 
        'foto'
    ]; 

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}