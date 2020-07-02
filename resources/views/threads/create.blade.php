@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form method="POST" action="/threads">
                        @csrf

                        <div class="form-group">
                            <label for="channel_id">Choose a Channel:</label>
                            <select class="form-control" id="channel_id" name="channel_id" required>

                                <option value="">Choose one...</option>

                                @foreach($channels as $channel)
                                    <option value="{{$channel->id}}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>
                                        {{ $channel->name }}
                                    </option>}}
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required />
                        </div>

                        <div class="form-group">
                            <label for="body">Title</label>
                            <textarea name="body" class="form-control" rows="8" id="body" required>{{ old('body')}}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        @if(count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection