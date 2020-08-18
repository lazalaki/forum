@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-component :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </span>
                            
                            @can ('update', $thread)
                                <form method="POST" action="{{ $thread->path() }}">
                                    @csrf
                                    @method('DELETE')
        
                                    <button class="btn btn-primary">Delete Thread</button>
                                </form>
                            @endcan

                        </div>
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                        
                    </div>                
                </div>

                <replies-component @added="repliesCount++" @removed="repliesCount--"></replies-component>

            </div>

            <div class="col-md-4">
                <div class="card mb-3">                
                    <div class="card-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a> and currently has 
                            <span v-text="repliesCount"></span> {{ Str::plural('comment', $thread->replies_count) }}.
                        </p>
                        <p>
                            <subscribe-button-component :avtive="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button-component>
                        </p>
                    </div>                
                </div>
            </div>
        </div>   
    </div>
</thread-component>
@endsection