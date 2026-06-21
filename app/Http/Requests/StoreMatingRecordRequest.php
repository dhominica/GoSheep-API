<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatingRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ewe_id' => 'required|exists:sheep,id',
            'ram_id' => 'required|exists:sheep,id',
            'recommendation_id' => 'nullable|exists:mating_recommendations,id',
            'mating_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:mating_date',
        ];
    }

    public function messages(): array
    {
        return [
            'ewe_id.required' => 'Domba betina (indukan) wajib diisi.',
            'ewe_id.exists' => 'Domba betina tidak ditemukan.',
            'ram_id.required' => 'Domba jantan wajib diisi.',
            'ram_id.exists' => 'Domba jantan tidak ditemukan.',
            'recommendation_id.exists' => 'Rekomendasi perkawinan tidak valid.',
            'mating_date.required' => 'Tanggal mulai perkawinan wajib diisi.',
            'mating_date.date' => 'Format tanggal mulai perkawinan tidak valid.',
            'end_date.required' => 'Tanggal selesai perkawinan wajib diisi.',
            'end_date.date' => 'Format tanggal selesai perkawinan tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ];
    }
}
