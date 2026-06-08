<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMatingCheckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'check_date' => 'required|date',
            'result' => 'required|in:pregnant,not_pregnant,failed,unknown',
            'notes' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'check_date.after_or_equal' => 'Tanggal pemeriksaan harus setelah tanggal mulai',
            'check_date.required' => 'Tanggal pemeriksaan wajib diisi',
            'check_date.date' => 'Format tanggal tidak valid',
            'result.required' => 'Hasil pemeriksaan wajib diisi',
            'result.in' => 'Hasil pemeriksaan harus pregnant, not_pregnant, failed, atau unknown',
            'notes.string' => 'Catatan harus berupa teks',
            'notes.max' => 'Catatan maksimal 255 karakter',
        ];
    }
}
