<?php

namespace Tests\Unit;


use App\Models\BidHistory;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BidHistoryModelTest extends TestCase
{
    use RefreshDatabase;

    public function testModelItemRelationship()
    {
        $item       = Item::factory()->create();
        $bidHistory = BidHistory::factory()->create(['item_id' => $item->id]);

        $this->assertEquals($item->id, $bidHistory->item->id);
        $this->assertEquals(1, $bidHistory->item()->count());
        $this->assertInstanceOf(Item::class, $bidHistory->item);
    }

    public function testModelUserRelationship()
    {
        $user       = User::factory()->create();
        $bidHistory = BidHistory::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $bidHistory->user->id);
        $this->assertEquals(1, $bidHistory->user()->count());
        $this->assertInstanceOf(User::class, $bidHistory->user);
    }
}
