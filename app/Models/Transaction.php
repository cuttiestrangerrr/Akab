<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_proyek',
        'id_pengguna',
        'id_developer',
        'total_bayar',
        'status_pembayaran',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_proyek');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'id_developer');
    }
}
