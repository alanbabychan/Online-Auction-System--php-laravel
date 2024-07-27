<?php

namespace Tests\Unit;


use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $helper;

    protected function setUp(): void
    {
        $this->helper = new UserRepository(new User());

        parent::setUp();
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $data = [
            'email'    => 'testme@email.com',
            'auto_bid' => 20
        ];

        $result = $this->helper->update($user, $data);

        $this->assertInstanceOf(User::class, $result);
        $this->assertDatabaseHas('users', $data);
    }
}
