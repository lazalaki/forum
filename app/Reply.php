<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];// favoritesCount je iz metode getFavoritesCountAttribute iz Favoritible.php, laravel sam prepoznaje sta se nalazi izmedju get i attribute
    
    protected static function boot()
    {
        parent::boot();

        static::created(function($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function($reply) {
            $reply->thread->decrement('replies_count');
        });
    }



    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }


    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }


    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinutes());//da li je created_at > od Carbon::now - 1min
    }


    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);

        return $matches[1];
    }


    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/', '<a href="/profiles/$1">$0</a>', $body);
    }
}
