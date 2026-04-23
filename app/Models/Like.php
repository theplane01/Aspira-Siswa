<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'id_like';
    public $incrementing = false;

    protected $fillable = [
        'id_like',
        'id_pelaporan',
        'nis',
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}
