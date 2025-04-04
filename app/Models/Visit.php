<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'country_id',
        'date_visited',
        'length_of_visit',
        'notes'
    ];

    /**
     * Return only those attached to the current user.
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeOwned($query, $userId = null)
    {
        $userId = $userId ?: auth()->id();
        return $query->where('user_id', $userId);
    }
}
