<?php

namespace App\Http\Requests\Kendaraan\Motor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tahun_keluaran' => 'integer',
            'warna' => 'string',
            'harga' => 'integer',
            'mesin' => 'required|string',
            'tipe_suspensi' => 'required|string',
            'tipe_transmisi' => 'required|string',
            'kendaraan_id' => 'string',
        ];
    }
}
