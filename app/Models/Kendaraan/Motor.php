<?php

namespace App\Models\Kendaraan;

use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'kendaraan_id',
        'mesin',
        'tipe_suspensi',
        'tipe_transmisi',
    ];

    protected $casts = [
        'kendaraan_id' => 'string',
        'mesin' => 'string',
        'tipe_suspensi' => 'string',
        'tipe_transmisi' => 'string',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
