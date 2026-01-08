<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
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
            'nis' => [
                'required',
                'string',
                Rule::unique('users', 'nis')->ignore($this->route('user')->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')->id),
            ],
            'name' => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'alamat' => 'nullable|string',
            'nama_orangtua' => 'nullable|string|max:100',
            'password' => 'nullable|min:6',
        ];
    }
}
