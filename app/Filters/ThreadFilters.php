<?php


namespace App\Filters;

use App\User;
use Symfony\Component\HttpFoundation\Request;

class ThreadFilters extends Filters {

    protected $filters = ['by', 'popular', 'unanswered'];

    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }


    protected function popular()
    {
        $this->builder->getQuery()->orders = [];// da izbaci latest() i gleda po popularnosti
        
        return $this->builder->orderBy('replies_count', 'desc');
    }


    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}