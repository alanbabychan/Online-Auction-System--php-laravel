<?php

namespace Tests\Unit;


use App\Models\BidHistory;
use App\Models\Item;
use App\Repository\ItemRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

use function dd;

class ItemRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $helper;

    protected function setUp(): void
    {
        $this->helper = new ItemRepository(new Item());

        parent::setUp();
    }

    public function testGetPaginatedList()
    {
        Item::factory(5)->create();

        $result = $this->helper->getPaginatedList(new Request());

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(5, $result->total());
    }

    public function testGetBids()
    {
        $item = Item::factory()->create();
        $bids = BidHistory::factory(5)->create(['item_id' => $item->id]);

        $result = $this->helper->getBids($item);

        $this->assertInstanceOf(Collection::class, $result);
    }
}
