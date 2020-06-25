<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp(); //Mora ovo jer extendujemo TestCase

        $this->thread = factory('App\Thread')->create();// Kreiranje threada

    }


    /** @test */
    public function a_user_can_view_all_threads()
    {
        // $thread = factory('App\Thread')->create(); //Threadu pristupamo sa $this->thread

        $this->get('/threads')
            ->assertSee($this->thread->title);


    }

    /** @test */
    function a_user_can_read_a_single_thread()
    {
        // $thread = factory('App\Thread')->create();

        $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);
    }
}

