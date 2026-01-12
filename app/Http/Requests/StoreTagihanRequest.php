<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagihanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tahun_ajaran' => 'required|string|max:20',
            'jenis_tagihan' => 'required',
            'nominal' => 'required|numeric|min:0',
            'tgl_tagihan' => 'required|date',
            'jatuh_tempo' => 'required|date|after_or_equal:tgl_tagihan',
        ];
    }
}
