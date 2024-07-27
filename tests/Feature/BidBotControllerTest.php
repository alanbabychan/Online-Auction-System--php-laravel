<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function auth;
use function route;

class BidBotControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotConfigureAutobidIfNotAuthenticated()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('autobid', $item));

        $response->assertRedirect(route('login'));
    }

    public function testUserCanActivateAutobiddingOnSpecificItem()
    {
        $this->authenticateUser();

        $item = Item::factory()->create();

        $response = $this->post(route('autobid', $item));

        $response->assertRedirect();
        $response->assertSessionHas(['success' => 'Operation was successful']);
        $this->assertDatabaseHas('bid_bots', [
            'item_id' => $item->id,
            'user_id' => auth()->user()->id
        ]);
    }

    public function testUserCanDeactivateAutobidding()
    {
        // activate autobbiding
        $this->testUserCanActivateAutobiddingOnSpecificItem();

        $item = Item::latest()->first();

        $response = $this->post(route('autobid', $item));

        $response->assertRedirect();
        $response->assertSessionHas(['success' => 'Operation was successful']);
        $this->assertDatabaseMissing('bid_bots', [
            'item_id' => $item->id,
            'user_id' => auth()->user()->id
        ]);
    }
}
