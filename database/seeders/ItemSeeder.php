<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

use function dd;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = Storage::disk('public')->files('images');

        foreach ($images as $image) {
            Item::factory()->create(['thumbnail' => 'storage/'.$image]);
        }
    }
}
