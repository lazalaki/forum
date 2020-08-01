@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8" style="float:none;margin:auto;">
                <div class="mb-3">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                    <hr>
                </div>
        
                @foreach ($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="level">
                                <span class="flex">
                                    <a href="#">{{ $thread->creator->name }}</a> said:
                                    {{ $thread->title }}
                                </span>
        
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}                    
                        </div>                
                    </div>
                @endforeach
                {{ $threads->links() }}
            </div>
        </div>
    </div>

@endsection