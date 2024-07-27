<?php

use App\Models\Item;

if (!function_exists('lastBidder')) {
    /**
     * Helper to grab the application name.
     *
     * @param  Item  $item
     *
     * @return mixed
     */
    function lastBidder(Item $item)
    {
        if ($item->bids()->count() <= 0) {
            return false;
        }

        return $item->bids()->latest()->first('user_id')['user_id'] === auth()->user()->id;
    }
}