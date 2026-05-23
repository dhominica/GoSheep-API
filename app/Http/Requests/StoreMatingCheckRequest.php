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
            'mating_record_id' => 'required|exists:mating_records,id',
            'check_date' => 'required|date',
            'result' => 'required|in:pregnant,failed,unknown',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }

    public function messages(): array
    {
        return [
            'mating_record_id.required' => 'ID riwayat kawin wajib diisi',
            'mating_record_id.exists' => 'Riwayat kawin tidak ditemukan',
            'check_date.required' => 'Tanggal pemeriksaan wajib diisi',
            'check_date.date' => 'Format tanggal tidak valid',
            'result.required' => 'Hasil pemeriksaan wajib diisi',
            'result.in' => 'Hasil pemeriksaan harus pregnant, failed, atau unknown',
        ];
    }
}
