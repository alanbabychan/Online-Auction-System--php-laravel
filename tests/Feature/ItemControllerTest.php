<?php

namespace Tests\Feature;

use App\Models\BidHistory;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

use function auth;
use function dd;
use function route;
use function var_dump;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListPaginatedItems()
    {
        // authenticate user
        $this->authenticateUser();
        // create items
        Item::factory(20)->create();

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $this->assertInstanceOf(LengthAwarePaginator::class, $response->getOriginalContent()->getData()['items']);
        $this->assertEquals(20, $response->getOriginalContent()->getData()['items']->total());
    }

    public function testListPaginatedItemsSorted()
    {
        // authenticate user
        $this->authenticateUser();
        // create items
        Item::factory(20)->create();

        $response = $this->get(route('dashboard', ['order' => 'desc']));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $this->assertInstanceOf(LengthAwarePaginator::class, $response->getOriginalContent()->getData()['items']);
        $this->assertEquals(20, $response->getOriginalContent()->getData()['items']->total());
    }

    public function testListPaginatedItemsWhenSearchedForSpecificItem()
    {
        // authenticate user
        $this->authenticateUser();
        // create items
        Item::factory(20)->create();

        $response = $this->get(route('dashboard', ['search_term' => 'test me']));

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $this->assertInstanceOf(LengthAwarePaginator::class, $response->getOriginalContent()->getData()['items']);
        $this->assertEquals(0, $response->getOriginalContent()->getData()['items']->total());
    }

    public function testShowDetailsPageOfSelectedItem()
    {
        // authenticate user
        $this->authenticateUser();
        // create item
        $item = Item::factory()->create();

        $response = $this->get(route('item.show', $item));

        $response->assertStatus(200);
        $response->assertViewIs('details');
        $this->assertArrayHasKey('item', $response->getOriginalContent()->getData());
        $this->assertArrayHasKey('bids', $response->getOriginalContent()->getData());
        $this->assertInstanceOf(Item::class, $response->getOriginalContent()->getData()['item']);
        $this->assertInstanceOf(Collection::class, $response->getOriginalContent()->getData()['bids']);
    }
}
