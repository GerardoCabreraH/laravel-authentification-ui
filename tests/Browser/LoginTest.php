<?php

namespace Tests\Browser;

use Laravel\Dusk\Chrome;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginUser()
    {
        $user = User::factory()->create([
            'email' => 'taylor@laravel.com',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(2000)
                    ->clickLink('Log in')
                    ->assertSee('Login')
                    ->pause(2000)
                    ->type('email', 'taylor@laravel.com')
                    ->pause(2000)
                    ->type('password', 'password')
                    ->pause(2000)
                    ->press('Login')
                    ->pause(2000)
                    ->assertPathIs('/home')
                    ->pause(2000)
                    ->assertSee('Dashboard')
                    ->pause(2000)
                    ->assertAuthenticated();
        });
    }

    /*public function testLoginUserLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs('taylor@laravel.com')
                    ->pause(2000)
                    ->visit('/home')
                    ->pause(2000)
                    ->clickLink('Logout')
                    ->assertGuest();
        });
    }*/

    /**
     * A basic browser test example.
     *
     * @return void
     */
    /*public function test_basic_example()
    {
        $user = User::factory()->create([
            'email' => 'taylor@laravel.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/home')
                    ->clickLink('Logout')
                    ->assertPathIs('/');
        });
    }*/
}
