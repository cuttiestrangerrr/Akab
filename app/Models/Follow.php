<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $primaryKey = 'id_follow';

    protected $fillable = [
        'id_pengguna',
        'id_developer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'id_developer');
    }
}
