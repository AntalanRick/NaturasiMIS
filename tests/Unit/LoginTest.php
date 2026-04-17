<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    // FR-LOGIN-01: User Input
    public function test_login_page_loads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    // FR-LOGIN-02: Required Fields
    public function test_login_requires_username_and_password()
    {
        $response = $this->post('/login', []);
        $response->assertSessionHasErrors(['username', 'password']);
    }

    // FR-LOGIN-03: Submit Login
    public function test_login_with_wrong_credentials()
    {
        $response = $this->post('/login', [
            'username' => 'wronguser',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors();
    }

    // FR-LOGIN-04: Feedback Message
    public function test_login_shows_error_on_failure()
    {
        $response = $this->post('/login', [
            'username' => 'wronguser',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors();
    }

    // FR-LOGIN-05: Forgot Password Guidance
    public function test_login_page_has_forgot_password_text()
    {
        $response = $this->get('/login');
        $response->assertSee('Contact');
    }
}