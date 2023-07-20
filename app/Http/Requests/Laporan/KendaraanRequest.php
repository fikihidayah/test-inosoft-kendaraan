<?php

namespace App\Http\Requests\Laporan;

use Illuminate\Foundation\Http\FormRequest;

class KendaraanRequest extends FormRequest
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
            'tgl_awal' => 'required|date_format:d-m-Y',
            'tgl_akhir' => 'required|date_format:d-m-Y',
            'tipe' => 'required|in:mobil,motor'
        ];
    }
}
