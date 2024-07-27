<?php

namespace Tests\Unit;

use App\Models\BidBot;
use App\Models\BidHistory;
use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemModelTest extends TestCase
{
    use RefreshDatabase;

    public function testModelBidsRelationship()
    {
        $item = Item::factory()->create();
        BidHistory::factory(3)->create(['item_id' => $item->id]);

        $this->assertEquals(3, $item->bids()->count());
        $this->assertInstanceOf(Collection::class, $item->bids);
    }

    public function testModelAutoBidRelationship()
    {
        $item = Item::factory()->create();
        BidBot::factory(3)->create(['item_id' => $item->id]);

        $this->assertEquals(3, $item->autoBid()->count());
        $this->assertInstanceOf(Collection::class, $item->autoBid);
    }
}
