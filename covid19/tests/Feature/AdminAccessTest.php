<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testLoginPageRenders()
    {
        $response = $this->get('/adminpass');

        $response
            ->assertStatus(200)
            ->assertSee('GIVE PASSWORD TO ACCESS ADMIN');
    }

    /**
     * @return void
     */
    public function testAdminshowRequiresAuthentication()
    {
        $response = $this->get('/adminshow');

        $response->assertRedirect('/adminpass');
    }

    /**
     * @return void
     */
    public function testWrongPasswordRedirectsBackWithMessage()
    {
        $response = $this->post('/adminpass', ['pass' => 'definitely-wrong']);

        $response
            ->assertRedirect('/adminpass')
            ->assertSessionHas('mssg', 'Password is not Correct');
    }

    /**
     * @return void
     */
    public function testCorrectPasswordAuthenticatesAndRedirects()
    {
        $response = $this->post('/adminpass', ['pass' => 'admin']);

        $response
            ->assertRedirect('/adminshow')
            ->assertSessionHas('admin_authenticated');
    }

    /**
     * @return void
     */
    public function testAuthenticatedUserCanAccessAdminshow()
    {
        $response = $this->withSession(['admin_authenticated' => true])->get('/adminshow');

        $response
            ->assertStatus(200)
            ->assertSee('COVID-19 Self-Assessment System Users Data');
    }

    /**
     * @return void
     */
    public function testAuthenticatedUserIsRedirectedAwayFromLoginPage()
    {
        $response = $this->withSession(['admin_authenticated' => true])->get('/adminpass');

        $response->assertRedirect('/adminshow');
    }
}