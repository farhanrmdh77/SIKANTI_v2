<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subbagian extends Model
{
    // Beri tahu Laravel nama tabel spesifiknya
    protected $table = 'subbagians';

    // Daftarkan kolom yang boleh diisi
    protected $fillable = [
        'nama_subbag', 'kode_klasifikasi'
    ];

    // (Opsional) Relasi balik ke tabel Users
    // Satu Subbagian bisa memiliki banyak User/Admin
    public function users()
    {
        return $this->hasMany(User::class, 'subbag_id', 'id');
    }

    // Relasi untuk menghitung jumlah arsip di subbagian (digunakan oleh Superadmin)
    public function arsips()
    {
        return $this->hasMany(Arsip::class, 'subbag_id', 'id');
    }
}