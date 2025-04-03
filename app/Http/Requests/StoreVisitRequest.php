<?php

namespace App\Http\Requests;

use App\DTOs\VisitDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreVisitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'date_visited' => 'required|date',
            'length_of_visit' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ];
    }
}
