<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePregnancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expected_birth_date' => 'required|date',
            'status'              => 'required|in:ongoing,birthed,miscarried',
            'end_date'            => 'required_if:status,birthed,miscarried|nullable|date',
            'notes'               => 'nullable|string|max:255',
            'total_lambs'         => 'required_if:status,birthed|nullable|integer|min:1|max:20',
            'birth_notes'         => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'expected_birth_date.required' => 'Tanggal perkiraan lahir wajib diisi',
            'expected_birth_date.date'     => 'Format tanggal perkiraan lahir tidak valid',
            'status.required'              => 'Status kehamilan wajib diisi',
            'status.in'                    => 'Status kehamilan harus berupa ongoing, birthed, atau miscarried',
            'end_date.required_if'         => 'Tanggal selesai/kelahiran/keguguran wajib diisi jika status tidak sedang berjalan',
            'end_date.date'                => 'Format tanggal selesai tidak valid',
            'notes.max'                    => 'Catatan maksimal 255 karakter',
            'total_lambs.required_if'      => 'Jumlah anak wajib diisi jika domba melahirkan',
            'total_lambs.integer'          => 'Jumlah anak harus berupa angka',
            'total_lambs.min'              => 'Jumlah anak minimal 1 ekor',
            'total_lambs.max'              => 'Jumlah anak maksimal 20 ekor',
            'birth_notes.max'              => 'Catatan kelahiran maksimal 500 karakter',
        ];
    }
}
