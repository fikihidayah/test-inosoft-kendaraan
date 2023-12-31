<?php

namespace App\Models\Kendaraan;

use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'kendaraan_id',
        'mesin',
        'kapasitas_penumpang',
        'tipe',
    ];

    protected $casts = [
        'kendaraan_id' => 'string',
        'mesin' => 'string',
        'kapasitas_penumpang' => 'integer',
        'tipe' => 'string',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
