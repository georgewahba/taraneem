<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_is_unavailable(): void
    {
        $this->get('/register')->assertNotFound();
        $this->get('/reg')->assertNotFound();
    }

    public function test_visitors_cannot_create_administration_accounts(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->post('/register', $data)->assertNotFound();
        $this->post('/reg', $data)->assertNotFound();
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }
}
