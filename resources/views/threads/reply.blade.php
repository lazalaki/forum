<reply-component :attributes="{{ $reply }}" inline-template v-cloak>

<div id="reply-{{ $reply->id }}" class="card mb-3">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">    
                <a href="{{ route('profile', $reply->owner->name) }}">
                    {{ $reply->owner->name }}
                </a>
                said {{ $reply->created_at->diffForHumans() }}
            </h5>

             <div>
                 <favorite-component :reply="{{ $reply }}"></favorite-component>
                {{-- <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                    @csrf
                    <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                    </button>
                 </form> --}}
             </div>
        </div>
    </div>         
        
    <div class="card-body">
        <div v-if="editing">
            <div class="form-group">
                <textarea class="form-control" v-model="body"></textarea>
            </div>
            <button class="btn btn-sm btn-outline-secondary" @click="update">Update</button>
            <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
        </div>
        <div v-else v-text="body"></div>
        
    </div>
    @can('update', $reply)
        <div class="card-footer level">
            <button class="btn btn-outline-secondary btn-sm mr-2" @click="editing = true">Edit</button>
            <button class="btn btn-outline-danger btn-sm mr-2" @click="destroy">Delete</button>

            {{-- <form action="/replies/{{$reply->id}}" method="POST">
                @csrf
                @method('DELETE')

                <button class="btn btn-outline-danger btn-sm">Delete</button>
            </form> --}}
        </div>
    @endcan
</div>
</reply-component>