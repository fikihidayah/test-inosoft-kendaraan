<?php

namespace App\Models\Kendaraan;

use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesin',
        'tipe_suspensi',
        'tipe_transmisi',
    ];

    protected $casts = [
        'mesin' => 'string',
        'tipe_suspensi' => 'string',
        'tipe_transmisi' => 'string',
    ];

    public function kendaraan()
    {
        $this->belongsTo(Kendaraan::class);
    }
}
