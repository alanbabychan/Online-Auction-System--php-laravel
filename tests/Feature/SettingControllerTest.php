<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function auth;
use function route;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowSettingsPage()
    {
        // authenticate user
        $this->authenticateUser();

        $response = $this->get(route('settings'));

        $response->assertStatus(200);
        $response->assertViewIs('settings');
    }

    public function testCannotVisitSettingsPageIfUnauthenticated()
    {
        $response = $this->get(route('settings'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testStoreAutobidSettings()
    {
        $this->authenticateUser();

        $response = $this->put(route('saveSettings'), ['auto_bid' => 20]);

        $this->assertDatabaseHas('users', ['auto_bid' => 20]);
        $response->assertSessionDoesntHaveErrors();
        $response->assertSessionHas(['success' => 'Settings Updated']);
    }

    public function testDisableAutoBidding()
    {
        $this->authenticateUser();

        $response = $this->put(route('saveSettings'));

        $this->assertDatabaseHas('users', ['auto_bid' => null, 'id' => auth()->user()->id]);
        $response->assertSessionDoesntHaveErrors();
        $response->assertSessionHas(['success' => 'Settings Updated']);
    }
}
