<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'notes',
    ];

    /**
     * @return BelongsToMany
     */
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'wishlist_country')
            ->using(WishlistCountry::class)
            ->withPivot([
                'start_date',
                'end_date',
                'notes'
            ])
            ->withTimestamps();
    }

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
