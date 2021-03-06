@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-component :thread="{{ $thread }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8" v-cloak>
                @include('threads._question')

                <replies-component @added="repliesCount++" @removed="repliesCount--"></replies-component>

            </div>

            <div class="col-md-4">
                <div class="card mb-3">                
                    <div class="card-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a> and currently has 
                            <span v-text="repliesCount"></span> {{ Str::plural('comment', $thread->replies_count) }}.
                        </p>
                        <p class="d-flex">
                            <subscribe-button-component 
                                :avtive="{{ json_encode($thread->isSubscribedTo) }}" 
                                v-if="signedIn">
                            </subscribe-button-component>

                            <button class="btn btn-secondary ml-2" 
                                v-if="authorize('isAdmin')" 
                                @click="toggleLock" 
                                v-text="locked ? 'Unlock' : 'Lock'">Lock
                            </button>
                        </p>
                    </div>                
                </div>
            </div>
        </div>   
    </div>
</thread-component>
@endsection