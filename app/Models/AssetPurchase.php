<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetPurchase extends Model
{
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id_aset',
        'id_pengguna',
        'total_bayar',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset3D::class, 'id_aset');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}
