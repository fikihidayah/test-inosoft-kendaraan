<?php

namespace App\Http\Requests\Kendaraan\Mobil;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'tahun_keluaran' => 'required|integer',
            'warna' => 'required|string',
            'harga' => 'required|integer',
            'mesin' => 'required|string',
            'kapasitas_penumpang' => 'required|integer',
            'tipe' => 'required|string'
        ];
    }
}
