<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Event::fake();

        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'johndoe@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest'
        ]);

        Event::assertDispatched(Registered::class);
    }



    /** @test */
    function user_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobarrr',
            'password_confirmation' => 'foobarrr'
        ]);


        $user = User::where('name', 'John')->firstOrFail();


        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))//register/confirm?token=confirmation_token
            ->assertRedirect(route('threads'));

        $this->assertTrue($user->fresh()->confirmed);
    }


    /** @test */
    function confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'Unknown token.');
    }
}
