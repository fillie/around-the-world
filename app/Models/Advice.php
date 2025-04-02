<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    /**
     * All mass assignable properties.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'country',
        'content',
        'start_date',
        'end_date',
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
