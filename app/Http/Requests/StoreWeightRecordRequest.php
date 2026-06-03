<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWeightRecordRequest extends FormRequest
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
            'sheep_id' => ['required', 'integer', 'exists:sheep,id'],
            'weight' => ['required', 'numeric', 'min:0', 'max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'sheep_id.required' => 'ID domba wajib diisi',
            'sheep_id.integer' => 'ID domba harus berupa angka',
            'sheep_id.exists' => 'Domba dengan ID tersebut tidak ditemukan',

            'weight.required' => 'Berat badan wajib diisi',
            'weight.numeric' => 'Berat badan harus berupa angka',
            'weight.min' => 'Berat badan minimal 0 kg',
            'weight.max' => 'Berat badan maksimal 200 kg',
        ];
    }
}
