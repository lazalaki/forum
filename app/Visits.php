<?php

// CUVANJE VISITA UZ POMOC REDISA



// namespace App;

// use Illuminate\Support\Facades\Redis;


// class Visits
// {
//     protected $thread;

//     public function __construct($thread)
//     {
//         $this->thread = $thread;
//     }


//     public function count()
//     {
//         return Redis::get($this->cacheKey()) ?? 0;
//     }


//     public function reset()
//     {
//         Redis::del($this->cacheKey());
        
//     }


//     public function cacheKey()
//     {
//         return "thread.{$this->thread->id}.visits";
//     }


//     public function record()
//     {
//         Redis::incr($this->cacheKey());

//         return $this;
//     }
// }