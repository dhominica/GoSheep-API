<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSheepRequest extends FormRequest
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
            'eartag' => 'required|string|max:50|unique:sheep,eartag',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'eartag_color' => 'required|string',

            'breed_id' => 'nullable|exists:breeds,id',
            'cage_id' => 'nullable|exists:cages,id',
            'sire_id' => 'nullable|exists:sheep,id',
            'dam_id' => 'nullable|exists:sheep,id',

            'weight' => 'required|numeric|min:0',

            'category' => 'required|string',
            'condition' => 'required|string',
            'severity' => 'required|in:normal,warning,critical',

            'notes' => 'nullable|string',
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

            'birth_date.date' => 'Tanggal lahir tidak valid',

            'eartag_color.string' => 'Warna tag harus berupa teks',

            'breed_id.exists' => 'Breed tidak ditemukan',
            'cage_id.exists' => 'Kandang tidak ditemukan',
            'sire_id.exists' => 'Sire tidak ditemukan',
            'dam_id.exists' => 'Dam tidak ditemukan',

            'weight.required' => 'Berat wajib diisi',
            'weight.numeric' => 'Berat harus berupa angka',
            'weight.min' => 'Berat tidak boleh kurang dari 0',

            'category.required' => 'Kategori kesehatan wajib dipilih',
            'category.string' => 'Kategori tidak valid',

            'condition.required' => 'Kondisi wajib dipilih',
            'condition.string' => 'Kondisi tidak valid',

            'severity.in' => 'Severity harus normal, warning, atau critical',

            'notes.string' => 'Catatan harus berupa teks',
        ];
    }
}
