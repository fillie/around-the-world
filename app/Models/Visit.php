<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'user_id',
        'country_id',
        'date_visited',
        'length_of_visit',
        'notes'
    ];

    public function scopeOwned($query, $userId = null)
    {
        $userId = $userId ?: auth()->id();
        return $query->where('user_id', $userId);
    }
}
