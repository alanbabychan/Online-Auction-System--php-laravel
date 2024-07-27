<?php

namespace Database\Factories;

use App\Models\BidHistory;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use function random_int;

class BidHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BidHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id'    => Item::factory()->create()->id,
            'user_id'    => User::factory()->create()->id,
            'bid_amount' => random_int(20, 1000),
        ];
    }
}
