@forelse($threads as $thread)
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                <h4 class="flex">
                                    <a href="{{ $thread->path() }}">
    
                                        @if(auth()->user() && $thread->hasUpdatesFor(auth()->user()))
    
                                            <strong>{{ $thread->title }}</strong>
    
                                        @else
    
                                            {{ $thread->title }}
    
                                        @endif
    
                                    </a>
                                </h4>
                                
                                <h5>
                                Created by: <a href="/profiles/{{$thread->creator->name}}">{{ $thread->creator->name }}</a>
                                </h5>
                            </div>

                            <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}</a>
                        </div>
                    </div>

                    <div class="card-body">                        
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                    <div class="card-footer">
                        {{ $thread->visits }} Visits
                    </div>
                </div>
                @empty
                    <p>There are no relevant results at this time</p>
            @endforelse