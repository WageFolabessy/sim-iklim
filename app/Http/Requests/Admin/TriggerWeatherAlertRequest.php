<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TriggerWeatherAlertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'level' => ['required', 'string', 'in:waspada,siaga,awas'],
            'title' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'level.required' => 'Level peringatan wajib diisi.',
            'level.in' => 'Level peringatan tidak valid.',
            'title.required' => 'Judul peringatan wajib diisi.',
            'area.required' => 'Area terdampak wajib diisi.',
            'body.required' => 'Deskripsi peringatan wajib diisi.',
        ];
    }
}
