<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Helper to authenticate user
     */
    protected function authenticateUser()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
    }

}
