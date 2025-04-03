<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWishlistRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'countries' => 'required|array|min:1',
            'countries.*.country_id'=> 'required|integer|exists:countries,id',
            'countries.*.start_date'=> 'required|date',
            'countries.*.end_date'=> 'required|date|after_or_equal:countries.*.start_date',
            'countries.*.notes'=> 'nullable|string',
        ];
    }
}
