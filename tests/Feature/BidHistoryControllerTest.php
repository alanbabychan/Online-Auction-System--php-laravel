<?php

namespace Tests\Feature;

use App\Exceptions\GeneralException;
use App\Jobs\TriggerAutoBid;
use App\Models\BidHistory;
use App\Models\Item;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

use function auth;
use function dd;
use function route;
use function var_dump;

class BidHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotSubmitBidIfNotAuthenticated()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('submitBid', $item));

        $response->assertRedirect(route('login'));
    }

    public function testUserCanSubmitBid()
    {
        Bus::fake();

        // authenticate user
        $this->authenticateUser();
        // create item
        $item = Item::factory()->create();

        $response = $this->post(route('submitBid', $item), ['bid' => ++$item->minimal_bid]);

        $response->assertRedirect();
        $response->assertSessionHas(['success' => 'Thank you, bid submitted']);
        $this->assertDatabaseHas('bid_histories', [
            'user_id'    => auth()->user()->id,
            'item_id'    => $item->id,
            'bid_amount' => $item->minimal_bid
        ]);
        // Assert that a job was dispatched
        Bus::assertDispatched(TriggerAutoBid::class);
    }

    public function testCannotBidIfItemNotActiveOrExpired()
    {
        $this->withoutExceptionHandling();

        // authenticate user
        $this->authenticateUser();
        // create item
        $item = Item::factory()->create(['active' => Item::INACTIVE]);

        try {
            $this->post(route('submitBid', $item), ['bid' => ++$item->minimal_bid]);
        } catch (Exception $exception) {
            $this->assertInstanceOf(GeneralException::class, $exception);
            $this->assertEquals('This auction has expired!', $exception->getMessage());
            $this->assertDatabaseMissing('bid_histories', [
                'user_id'    => auth()->user()->id,
                'item_id'    => $item->id,
                'bid_amount' => $item->minimal_bid
            ]);
        }
    }

    public function testCannotBidIfBidSmallerThanLast()
    {
        $this->withoutExceptionHandling();

        // authenticate user
        $this->authenticateUser();
        // create item
        $item = Item::factory()->create();
        // create bid
        $bidHistory = BidHistory::factory()->create([
            'item_id' => $item->id,
            'user_id' => auth()->user()->id
        ]);

        try {
            $this->post(route('submitBid', $item), ['bid' => --$bidHistory->bid_amount]);
        } catch (Exception $exception) {
            $this->assertInstanceOf(GeneralException::class, $exception);
            $this->assertEquals('You bid should be bigger than the last one!', $exception->getMessage());
            $this->assertDatabaseMissing('bid_histories', [
                'user_id'    => auth()->user()->id,
                'item_id'    => $item->id,
                'bid_amount' => $bidHistory->bid_amount
            ]);
        }
    }

    public function testCannotBidIfBidAmountSmallerThanMinimumBid()
    {
        $this->withoutExceptionHandling();

        // authenticate user
        $this->authenticateUser();
        // create item
        $item = Item::factory()->create();

        try {
            $this->post(route('submitBid', $item), ['bid' => --$item->minimal_bid]);
        } catch (Exception $exception) {
            $this->assertInstanceOf(GeneralException::class, $exception);
            $this->assertEquals('Please submit at least minimal bid amount !', $exception->getMessage());
            $this->assertDatabaseMissing('bid_histories', [
                'user_id'    => auth()->user()->id,
                'item_id'    => $item->id,
                'bid_amount' => $item->minimal_bid
            ]);
        }
    }
}
