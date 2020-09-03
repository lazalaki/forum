<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    function a_thread_can_be_updated_by_its_creator()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed',
            'body' => 'Changed body.'
        ]);

        tap($thread->fresh(), function($thread){
            $this->assertEquals($thread->title, 'Changed');
            $this->assertEquals($thread->body, 'Changed body.');
        });
    }



    /** @test */
    function unauthorized_users_may_not_update_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => create('App\User')]);

        $this->patch($thread->path(), [])->assertStatus(403);
    }



    /** @test */
    function a_thread_requires_title_and_body_to_be_updated()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed',
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(), [
            'body' => 'Changed',
        ])->assertSessionHasErrors('title');
    }
}
