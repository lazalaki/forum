<?php

namespace App;

use App\Filters\ThreadFilters;
use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected $casts = [
        'locked' => 'boolean'
    ];



    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('replyCount', function($builder) {
        //     $builder->withCount('replies');
        // });

        static::deleting(function ($thread)
        {
            $thread->replies->each(function($reply) {
                $reply->delete();
            });            
        });


        static::created(function ($thread)
        {
            $thread->update(['slug' => $thread->title]);            
        });
    }

    

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    } 

    

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }


    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));//Ovo je sa eventom i listenerima

        return $reply;
    }


    // public function notifySubscribers($reply)
    // {
    //     $this->subscriptions
    //         ->where('user_id', '!=', $reply->user_id)// Prebaceno u listnere
    //         ->each
    //         ->notify($reply);
    // }


    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }


    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }


    public function unsubscribe($userId = null)
    {
        $this->subscriptions('where', $userId ?: auth()->id())->delete();
    }


    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }


    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }


    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }


    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }

}
