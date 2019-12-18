<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // https://medium.com/@DCzajkowski/testing-laravel-authentication-flow-573ea0a96318
    public function test_user_can_view_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_login_page_when_logged_in()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');
        
        $response->assertRedirect('/home');
    }

    public function test_user_can_login_with_correct_password()
    {
        // https://stackoverflow.com/q/50655984
        $this->withoutExceptionHandling();
        // https://laracasts.com/discuss/channels/laravel/laravelphpunit-testing-tokenmismatchexception?page=1#reply=428728

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'correct-password'),
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password()
    {
        // https://stackoverflow.com/q/53122558
        // https://stackoverflow.com/a/55787290
        $user = factory(User::class)->create([
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        // $response->assertRedirect('/login'); // ?
        $response->assertSessionHasErrors('username');
        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
