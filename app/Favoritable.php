<?php

namespace App;

trait Favoritable 
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');//favorited prefix
    }



    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if(!$this->favorites()->where($attributes)->exists()) {
           return $this->favorites()->create($attributes);//zato sto eloquent koristi polimorph relationship automatski ce staviti favorited_id i favorited_type
        }
    }



    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }



    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}