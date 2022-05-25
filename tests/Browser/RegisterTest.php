<?php

namespace Tests\Browser;

use Laravel\Dusk\Chrome;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegisterUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(2000)
                    ->clickLink('Register')
                    ->pause(2000)
                    ->assertSee('Register')
                    ->pause(2000)
                    ->type('name', 'Gerardo Cabrera')
                    ->pause(2000)
                    ->type('email', 'gerardorafael.cabrera@gmail.com')
                    ->pause(2000)
                    ->type('password', '123laravel456')
                    ->pause(2000)
                    ->type('password_confirmation', '123laravel456')
                    ->pause(2000)
                    ->press('Register')
                    ->assertPathIs('/home')
                    ->pause(2000)
                    ->assertSee('Dashboard')
                    ->pause(2000)
                    ->assertAuthenticated();
        });
    }

    /*public function testRegisterUserLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs('gerardorafael.cabrera@gmail.com')
                    ->pause(2000)
                    ->visit('/home')
                    ->pause(2000)
                    ->clickLink('Logout')
                    ->pause(2000)
                    ->assertGuest();
        });
    }*/
}
