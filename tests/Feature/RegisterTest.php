<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Providers\RouteServiceProvider;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /** @test */
    public function new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function new_users_name_is_required()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function new_users_email_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function new_users_email_is_wrong()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'dsfsdfasdrg',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function new_users_password_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function new_users_confirm_password_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function new_users_password_not_equal_to_password_confirmation()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password-wrong',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function new_users_password_confirmation_not_equal_to_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password-wrong',
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function new_users_empty_data()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/
}
