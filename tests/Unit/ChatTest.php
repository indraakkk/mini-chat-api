<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login_or_create_user()
    {
        $user = User::factory()->count(1)->make()->first();

        $response = $this->post('/api/v1/login',
            [
                'name' => $user->name,
                'email' => $user->email
            ]
        );

        $response->assertStatus(200);
    }
}
