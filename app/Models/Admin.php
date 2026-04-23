<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins'; // Nama tabel di database kau
    protected $primaryKey = 'id_admin'; // Sesuai PDF UKK kau
    protected $fillable = ['username', 'password', 'nama_admin'];
}