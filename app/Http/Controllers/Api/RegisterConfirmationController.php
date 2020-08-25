<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        

        try {
            $user = User::where('confirmation_token', request('token'))->firstOrFail();
        $user->confirm();
        } catch(Exception $e) {
            return redirect(route('threads'))
            ->with('flash', 'Unknown token.');
        }

        return redirect('/threads')
            ->with('flash', 'Your account is now confirmed! You may post to the forum.');
    }
}
