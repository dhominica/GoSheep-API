<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeightRecordRequest extends FormRequest
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
            'weight' => ['required', 'numeric', 'min:0.1', 'max:200'],
        ];
    }

    /**
     * Get the custom validation messages.
     */
    public function messages(): array
    {
        return [
            'weight.required' => 'Berat badan wajib diisi',
            'weight.numeric' => 'Berat badan harus berupa angka',
            'weight.min' => 'Berat badan minimal 0.1 kg',
            'weight.max' => 'Berat badan maksimal 200 kg',
        ];
    }
}
