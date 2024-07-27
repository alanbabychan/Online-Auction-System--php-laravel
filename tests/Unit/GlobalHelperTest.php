<?php

namespace Tests\Unit;

use App\Models\BidHistory;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function auth;
use function lastBidder;

class GlobalHelperTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckIfUserIsLastBidder()
    {
        $this->authenticateUser();

        $item = Item::factory()->create();
        BidHistory::factory()->create(['user_id' => auth()->user()->id, 'item_id' => $item->id]);

        $this->assertTrue(lastBidder($item));
    }

    public function testReturnFalseWhenNoBidHistory()
    {
        $item = Item::factory()->create();

        $this->assertFalse(lastBidder($item));
    }
}
