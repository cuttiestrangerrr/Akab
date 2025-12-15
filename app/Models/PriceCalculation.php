<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceCalculation extends Model
{
    protected $primaryKey = 'id_kalkulator';

    protected $fillable = [
        'id_pengguna',
        'id_developer',
        'fitur_dipilih',
        'estimasi_harga',
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
