<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id_komentar';
    public $incrementing = false;

    protected $fillable = [
        'id_komentar',
        'id_pelaporan',
        'nis',
        'komentar',
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
