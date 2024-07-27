<?php

namespace Tests\Unit;

use App\Models\BidHistory;
use App\Models\Item;
use App\Models\User;
use App\Repository\BidHistoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use function auth;

class BidHistoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $helper;

    protected function setUp(): void
    {
        $this->helper = new BidHistoryRepository(new BidHistory());

        parent::setUp();
    }

    public function testRepositoryCanStoreData()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();

        $data = [
            'item_id'    => $item->id,
            'user_id'    => $user->id,
            'bid_amount' => 20
        ];

        $result = $this->helper->store($data);

        $this->assertInstanceOf(BidHistory::class, $result);
        $this->assertDatabaseHas('bid_histories', $data);
    }

    public function testGetLatestBidder()
    {
        $item = Item::factory()->create();
        BidHistory::factory(2)->create(['item_id' => $item->id]);

        $result = $this->helper->getLatestBidder($item);

        $this->assertInstanceOf(BidHistory::class, $result);
    }
}
