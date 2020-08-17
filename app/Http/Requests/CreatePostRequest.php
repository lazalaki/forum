<?php

namespace App\Http\Requests;

use App\Reply;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Reply());
    }

    protected function failedAuthorization()// pregazena metoda
    {
        throw new ThrottleRequestsException('You are replying to frequently. Please taka a break.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }


    // public function persist($thread)
    // {
    //     return $thread->addReply([
    //         'body' => request('body'),
    //         'user_id' => auth()->id()
    //     ])->load('owner');
    // }
}
