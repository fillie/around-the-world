<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class WishlistCountry extends Pivot
{
    /**
     * @var string
     */
    protected $table = 'wishlist_country';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'wishlist_id',
        'country_id',
        'start_date',
        'end_date',
        'notes'
    ];

    /**
     * @var bool
     */
    public $timestamps = true;
}
