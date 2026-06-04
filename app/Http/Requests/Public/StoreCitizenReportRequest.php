<?php

namespace App\Http\Requests\Public;

use App\Enums\AnomalyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreCitizenReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'reporter_name' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'anomaly_type' => ['required', 'string', new Enum(AnomalyType::class)],
            'description' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'location.required' => 'Lokasi wajib diisi.',
            'location.string' => 'Lokasi harus berupa teks.',
            'anomaly_type.required' => 'Jenis anomali wajib dipilih.',
            'anomaly_type.Illuminate\Validation\Rules\Enum' => 'Jenis anomali yang dipilih tidak valid.',
            'description.required' => 'Deskripsi laporan wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'reporter_name' => 'nama pelapor',
            'location' => 'lokasi',
            'anomaly_type' => 'jenis anomali',
            'description' => 'deskripsi',
        ];
    }
}
