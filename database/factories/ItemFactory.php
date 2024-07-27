<?php

namespace Database\Factories;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use function now;
use function random_int;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->company,
            'description' => $this->faker->realText(),
            'minimal_bid' => random_int(5, 100),
            'total_bids'  => 0,
            'thumbnail'   => '',
            'active'      => Item::ACTIVE,
            'expires_at'  => Carbon::now()->addWeek()
        ];
    }
}
