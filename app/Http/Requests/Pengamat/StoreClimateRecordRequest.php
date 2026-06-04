<?php

namespace App\Http\Requests\Pengamat;

use Illuminate\Foundation\Http\FormRequest;

class StoreClimateRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'recorded_at' => ['required', 'date'],
            'temperature' => ['required', 'numeric'],
            'humidity' => ['required', 'integer'],
            'rainfall' => ['required', 'numeric'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'recorded_at.required' => 'Tanggal pencatatan wajib diisi.',
            'recorded_at.date' => 'Tanggal pencatatan harus berupa tanggal yang valid.',
            'temperature.required' => 'Suhu wajib diisi.',
            'temperature.numeric' => 'Suhu harus berupa angka.',
            'humidity.required' => 'Kelembaban wajib diisi.',
            'humidity.integer' => 'Kelembaban harus berupa bilangan bulat.',
            'rainfall.required' => 'Curah hujan wajib diisi.',
            'rainfall.numeric' => 'Curah hujan harus berupa angka.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'recorded_at' => 'tanggal pencatatan',
            'temperature' => 'suhu',
            'humidity' => 'kelembaban',
            'rainfall' => 'curah hujan',
        ];
    }
}
