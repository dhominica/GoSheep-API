<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHealthRecordRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sheep_id'  => ['required', 'integer', 'exists:sheep,id'],
            'category'  => ['required', 'string', 'in:health,environment,nutrition,maintenance'],
            'condition' => ['required', 'string', 'max:255'],
            'severity'  => ['required', 'string', 'in:normal,ringan,sedang,berat'],
            'notes'     => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'sheep_id.required' => 'ID domba wajib diisi',
            'sheep_id.integer' => 'ID domba harus berupa angka',
            'sheep_id.exists' => 'Domba dengan ID tersebut tidak ditemukan',

            'category.required' => 'Kategori wajib dipilih',
            'category.string' => 'Kategori harus berupa teks',
            'category.in' => 'Kategori harus salah satu dari: health, environment, nutrition, maintenance',

            'condition.required' => 'Kondisi wajib diisi',
            'condition.string' => 'Kondisi harus berupa teks',
            'condition.max' => 'Kondisi maksimal 255 karakter',

            'severity.required' => 'Tingkat keparahan wajib dipilih',
            'severity.string' => 'Tingkat keparahan harus berupa teks',
            'severity.in' => 'Tingkat keparahan harus salah satu dari: normal, ringan, sedang, berat',

            'notes.string' => 'Catatan harus berupa teks',
        ];
    }
}
