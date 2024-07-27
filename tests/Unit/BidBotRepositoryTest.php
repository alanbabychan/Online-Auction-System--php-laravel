<?php

namespace Tests\Unit;


use App\Models\BidBot;
use App\Models\BidHistory;
use App\Models\Item;
use App\Repository\BidBotRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function auth;
use function dd;

class BidBotRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $helper;

    protected function setUp(): void
    {
        $this->helper = new BidBotRepository(new BidBot());

        parent::setUp();
    }

    public function testGetBots()
    {
        $item       = Item::factory()->create();
        $bidBot     = BidBot::factory()->create(['item_id' => $item->id]);
        $bidHistory = BidHistory::factory()->create();

        $result = $this->helper->getBots($item, $bidHistory);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(1, $result->count());
    }

    public function testActivateBiddingBot()
    {
        $this->authenticateUser();

        $item = Item::factory()->create();

        $data = [
            'item_id' => $item->id,
            'user_id' => auth()->user()->id
        ];

        $this->helper->activateOrDeactivate($item, $data);

        $this->assertDatabaseHas('bid_bots', $data);
    }

    public function testDeactivateBiddingBot()
    {
        $this->testActivateBiddingBot();

        $item = Item::first();

        $data = [
            'item_id' => $item->id,
            'user_id' => auth()->user()->id
        ];

        $this->helper->activateOrDeactivate($item, $data);

        $this->assertDatabaseMissing('bid_bots', $data);
    }
}
