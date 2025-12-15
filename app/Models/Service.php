<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_service';

    protected $fillable = [
        'id_developer',
        'judul',
        'deskripsi',
        'harga_mulai',
        'thumbnail',
        'kategori',
        'addons',
        'views_count',
    ];

    protected $casts = [
        'addons' => 'array',
    ];

    public function developer()
    {
        return $this->belongsTo(User::class, 'id_developer');
    }
}
