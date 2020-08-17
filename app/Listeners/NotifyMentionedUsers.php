<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouAreMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        collect($event->reply->mentionedUsers())
            ->map(function ($name) {
                return User::where('name', $name)->first();
            })
            ->filter()
            ->each(function ($user) use ($event) {
                $user->notify(new YouAreMentioned($event->reply));
            });

        // $mentionedUsers = $event->reply->mentionedUsers();

        // foreach($mentionedUsers as $name) {
        //     $user = User::where('name', $name)->first();

        //     if($user) {
        //         $user->notify(new YouAreMentioned($event->reply));
        //     }
        // }
    }
}
