<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHealthRecordRequest extends FormRequest
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
            'category'  => ['sometimes', 'string', 'in:health,environment,nutrition,maintenance'],
            'condition' => ['sometimes', 'string', 'max:255'],
            'severity'  => ['sometimes', 'string', 'in:normal,ringan,sedang,berat'],
            'notes'     => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.in'       => 'Kategori harus salah satu dari: health, environment, nutrition, maintenance',
            'condition.max'     => 'Kondisi maksimal 255 karakter',
            'severity.in'       => 'Tingkat keparahan harus salah satu dari: normal, ringan, sedang, berat',
            'notes.string'      => 'Catatan harus berupa teks',
        ];
    }
}
