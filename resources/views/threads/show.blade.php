@extends('layouts.app')

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

                <replies-component :data="{{ $thread->replies }}" @removed="repliesCount--"></replies-component>


                {{ $replies->links() }}

                @if(auth()->check())
                    <form method="POST" action={{ $thread->path() . '/replies' }}>
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" rows="5" placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href={{ route('login')}}>Log In</a> to participate in this discussion</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card mb-3">                
                    <div class="card-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a> and currently has 
                            <span v-text="repliesCount"></span> {{ Str::plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>                
                </div>
            </div>
        </div>   
    </div>
</thread-component>
@endsection