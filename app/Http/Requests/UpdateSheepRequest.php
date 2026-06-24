<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSheepRequest extends FormRequest
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
        $sheepId = $this->route('id');

        return [
            'eartag'       => "required|string|max:50|unique:sheep,eartag,{$sheepId}",
            'gender'       => 'required|in:male,female',
            'birth_date'   => 'required|date',
            'eartag_color' => 'required|string',

            'breed_id' => 'nullable|exists:breeds,id',
            'cage_id'  => 'nullable|exists:cages,id',
            'sire_id'  => 'nullable|exists:sheep,id',
            'dam_id'   => 'nullable|exists:sheep,id',

            'status' => 'required|in:active,sold,dead',
        ];
    }

    public function messages(): array
    {
        return [
            'eartag.required' => 'Eartag wajib diisi',
            'eartag.string' => 'Eartag harus berupa teks',
            'eartag.max' => 'Eartag maksimal 50 karakter',
            'eartag.unique' => 'Eartag sudah digunakan',

            'gender.required' => 'Gender wajib dipilih',
            'gender.in' => 'Gender harus male atau female',

            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'birth_date.date' => 'Tanggal lahir tidak valid',

            'eartag_color.required' => 'Warna tag wajib diisi',
            'eartag_color.string' => 'Warna tag harus berupa teks',

            'breed_id.exists' => 'Breed tidak ditemukan',
            'cage_id.exists' => 'Kandang tidak ditemukan',
            'sire_id.exists' => 'Sire tidak ditemukan',
            'dam_id.exists' => 'Dam tidak ditemukan',

            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status harus active, sold, atau dead',
        ];
    }
}
