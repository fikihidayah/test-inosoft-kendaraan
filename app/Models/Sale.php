<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'kendaraan_id',
        'jumlah',
        'total_harga',
    ];

    protected $casts = [
        'kendaraan_id' => 'string',
        'jumlah' => 'integer',
        'total_harga' => 'integer',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
