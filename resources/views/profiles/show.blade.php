@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8" style="float:none;margin:auto;">
                <div class="mb-3">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                    <hr>
                </div>
        
                @forelse ($activities as $date => $activity)
                    <h3>{{$date}}</h3>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include ("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                    @empty
                    <p>There is no activity for this user</p>
                @endforelse
            </div>
        </div>
    </div>

@endsection