<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    //kreiranje sa make() i create() smo prebacili u tests/utiliti/functions.php

    /** @test */
    function guests_may_not_create_threads()
    {

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');

        // $this->expectException('Illuminate\Auth\AuthenticationException');
        // $this->withoutExceptionHandling();

        // $thread = make('App\Thread');

        // $this->post('/threads', $thread->toArray());
    }




    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread');//create()-kreira i sacuva u bazi make()-samo kreira, a raw()-daje array atributa

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }


    /** @test */
    function guests_cannot_delete_threads()
    {
        $this->withExceptionHandling();
        
        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect('/login');
    }



    /** @test */
    function a_thread_can_be_deleted()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }



    /** @test */
    function threads_may_only_be_deleted_by_those_who_have_permission()
    {
        
    }



    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');       
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');       
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
            
        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }


    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
