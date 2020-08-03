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
        
                @foreach ($activities as $date => $activity)
                    <h3>{{$date}}</h3>
                    @foreach($activity as $record)
                        @include ("profiles.activities.{$record->type}", ['activity' => $record])
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

@endsection