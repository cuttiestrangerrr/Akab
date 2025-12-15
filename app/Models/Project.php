<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $primaryKey = 'id_proyek';

    protected $fillable = [
        'id_pengguna',
        'id_developer',
        'nama_proyek',
        'deskripsi',
        'harga_estimasi',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'id_developer');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_proyek');
    }
}
