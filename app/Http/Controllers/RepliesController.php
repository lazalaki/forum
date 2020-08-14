<?php

namespace App\Http\Controllers;

use App\Reply;
use Exception;
use App\Thread;
use App\Inspections\Spam;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);    
    }


    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    
    public function store($channelId ,Thread $thread)
    {
        try {
            $this->validateReply();
        
            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch (Exception $exception) {
            return response('Sorry , your reply could not be saved', 422);
        } 
        
        return $reply->load('owner');
    }


    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {           
            $this->validateReply();
            $reply->update(['body' => request('body')]);
        } catch(Exception $e) {
            return response('Sorry , your reply could not be saved', 422);
        }
        
    }


    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if(request()->expectsJson()) {
            return response(['status' => 'Reply Deleted']);
        }

        return back();
    }


    public function validateReply()
    {
        request()->validate(['body' => 'required']);

        resolve(Spam::class)->detect(request('body'));
    }
}
