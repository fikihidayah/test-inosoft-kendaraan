<?php

namespace App\Models;

use App\Models\Kendaraan\Mobil;
use App\Models\Kendaraan\Motor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_keluaran',
        'warna',
        'harga',
        'stok'
    ];

    protected $casts = [
        'tahun_keluaran' => 'integer',
        'warna' => 'string',
        'harga' => 'integer',
        'stok' => 'integer',
    ];

    public function motor()
    {
        return $this->hasOne(Motor::class);
    }

    public function mobil()
    {
        return $this->hasOne(Mobil::class);
    }
}
