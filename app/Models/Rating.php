<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $primaryKey = 'id_rating';

    protected $fillable = [
        'id_pengguna',
        'id_developer',
        'nilai_rating',
        'ulasan',
    ];

    public function rater()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function ratedDeveloper()
    {
        return $this->belongsTo(User::class, 'id_developer');
    }
}
