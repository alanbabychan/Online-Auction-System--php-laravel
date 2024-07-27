<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory, Uuids;

    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $guarded = [];

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', self::ACTIVE);
    }

    /**
     * @return HasMany
     */
    public function bids(): HasMany
    {
        return $this->hasMany(BidHistory::class, 'item_id');
    }

    /**
     * @return HasMany
     */
    public function autoBid(): HasMany
    {
        return $this->hasMany(BidBot::class, 'item_id');
    }
}
