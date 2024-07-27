<?php

namespace Tests\Unit;

use App\Models\BidBot;
use App\Models\BidHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function testModelBidsRelationship()
    {
        $user = User::factory()->create();
        BidHistory::factory(3)->create(['user_id' => $user->id]);

        $this->assertEquals(3, $user->bids()->count());
        $this->assertInstanceOf(Collection::class, $user->bids);
    }

    public function testModelAutoBidRelationship()
    {
        $user = User::factory()->create();
        BidBot::factory(3)->create(['user_id' => $user->id]);

        $this->assertEquals(3, $user->autoBid()->count());
        $this->assertInstanceOf(Collection::class, $user->autoBid);
    }
}
