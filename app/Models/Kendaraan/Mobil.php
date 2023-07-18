<?php

namespace App\Models\Kendaraan;

use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesin',
        'kapasitas_penumpang',
        'tipe',
    ];

    protected $casts = [
        'mesin' => 'string',
        'kapasitas_penumpang' => 'string',
        'tipe' => 'string',
    ];

    public function kendaraan()
    {
        $this->belongsTo(Kendaraan::class);
    }
}
