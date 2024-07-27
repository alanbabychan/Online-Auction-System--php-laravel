<?php

namespace Tests\Unit;

use App\Models\BidBot;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use function dd;

class BidBotModelTest extends TestCase
{
    use RefreshDatabase;

    public function testModelItemRelationship()
    {
        $item   = Item::factory()->create();
        $bidBot = BidBot::factory()->create(['item_id' => $item->id]);

        $this->assertEquals($item->id, $bidBot->item->id);
        $this->assertEquals(1, $bidBot->item()->count());
        $this->assertInstanceOf(Item::class, $bidBot->item);
    }

    public function testModelUserRelationship()
    {
        $user   = User::factory()->create();
        $bidBot = BidBot::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $bidBot->user->id);
        $this->assertEquals(1, $bidBot->user()->count());
        $this->assertInstanceOf(User::class, $bidBot->user);
    }
}
