<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdviceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'countries' => 'required|array|min:1',
            'countries.*' => 'string|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'countries.required' => 'At least one country is required.',
            'start_date.required' => 'A start date is required.',
            'end_date.required' => 'An end date is required.',
            'start_date.after_or_equal' => 'Start date must be today or later.',
            'end_date.after_or_equal' => 'End date must be on or after the start date.',
        ];
    }
}
