<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset3D extends Model
{
    protected $table = 'assets_3d';
    protected $primaryKey = 'id_aset';
    
    protected $fillable = [
        'id_developer',
        'nama_aset',
        'deskripsi',
        'harga',
        'file_url',
    ];

    public function developer()
    {
        return $this->belongsTo(User::class, 'id_developer');
    }
}
