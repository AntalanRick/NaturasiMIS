<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginFunctionalTest extends TestCase
{
    use RefreshDatabase;

    // FR-LOGIN-01: Login page loads and shows input fields
    public function test_login_page_shows_username_and_password_fields()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('name="username"', false);
        $response->assertSee('name="password"', false);
    }

    // FR-LOGIN-02: Required fields - cannot submit empty form
    public function test_cannot_submit_empty_login_form()
    {
        $response = $this->post('/login', []);
        $response->assertSessionHasErrors(['username', 'password']);
    }

    // FR-LOGIN-03: Log In button submits the form
    public function test_login_form_can_be_submitted()
    {
        $response = $this->post('/login', [
            'username' => 'testuser',
            'password' => 'testpassword',
        ]);
        $response->assertRedirect();
    }

    // FR-LOGIN-04: Error message shown on failed login
    public function test_error_message_shown_on_wrong_credentials()
    {
        $response = $this->post('/login', [
            'username' => 'wronguser',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors();
    }

    // FR-LOGIN-05: Forgot password guidance is visible
    public function test_forgot_password_guidance_is_visible()
    {
        $response = $this->get('/login');
        $response->assertSee('Contact');
        $response->assertSee('Administrator');
    }
}