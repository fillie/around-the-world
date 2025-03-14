<?php

namespace App\Http\Requests;

use App\DTO\VisitDTO;
use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'country_id'      => 'required|exists:countries,id',
            'date_visited'    => 'required|date',
            'length_of_visit' => 'required|integer|min:1',
            'notes'           => 'nullable|string'
        ];
    }


    /**
     * Return the validated data as a strongly typed DTO.
     */
    public function toDTO(): VisitDTO
    {
        $data = $this->validated();
        return new VisitDTO(
            country_id: (int) $data['country_id'],
            date_visited: $data['date_visited'],
            length_of_visit: (int) $data['length_of_visit'],
            notes: $data['notes'] ?? null
        );
    }
}
