<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = ['user1', 'user2', 'user3', 'user4'];

        foreach ($users as $user) {
            User::factory()->create(['username' => $user]);
        }
    }
}
