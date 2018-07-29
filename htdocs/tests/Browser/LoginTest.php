<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Log;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        LOG::info('[dusk] testLogin');

        $this->browse(function ($browser) {

            $browser->visit('/login')
                    ->type('email', 'test@gmail.com')
                    ->type('password', 'sld001')
                    ->press('サインイン')
                    ->assertPathIs('/');
        });
    }

}
