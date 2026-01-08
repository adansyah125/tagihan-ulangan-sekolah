<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'nis'           => 'required|string|unique:users,nis',
            'email'         => 'required|email|unique:users,email',
            'nama'          => 'required|string|max:255',
            'kelas'         => 'required|string|max:50',
            'alamat'        => 'nullable|string',
            'nama_orangtua' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nis.required'   => 'NIS wajib diisi',
            'nis.unique'     => 'NIS sudah terdaftar',
            'email.unique'   => 'Email sudah terdaftar',
        ];
    }
}
