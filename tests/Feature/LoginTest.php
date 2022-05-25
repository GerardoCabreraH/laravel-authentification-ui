<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test **/
    public function login_email_is_required()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test **/
    public function login_email_is_wrong_data()
    {
        $response = $this->post('/login', [
            'email' => 'zxfdsfdasffg',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    /** @test **/
    public function login_password_is_required()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '',
        ]);
        $this->assertGuest();
        $response->assertSessionHasErrors(['password']);
    }

    /** @test **/
    public function login_empty_data()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);
        $this->assertGuest();
        $response->assertSessionHasErrors(['email', 'password']);
    }

    /** @test */
    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
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
