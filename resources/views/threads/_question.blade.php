
{{-- Editing --}}

<div class="card mb-3" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" value="{{ $thread->title }}" class="form-control" v-model="form.title"> 
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <textarea class="form-control" rows="10" v-model="form.body"></textarea>
        </div>       
    </div>    
    
    <div class="card-footer">
        <div class="level">
            <button class="btn btn-secondary" @click="editing = true" v-show="!editing">Edit</button>
            <button class="btn btn-secondary" @click="update">Update</button>
            <button class="btn btn-secondary ml-2" @click="resetForm">Cancel</button>
                @can ('update', $thread)
                    <form method="POST" action="{{ $thread->path() }}" class="ml-auto">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-primary">Delete Thread</button>
                    </form>
                @endcan       
        </div>
    </div>
</div>


{{-- Viewing --}}

<div class="card mb-3" v-else="!editing">
    <div class="card-header">
        <div class="level">
            <img src="{{ $thread->creator->avatar_path }}"
                     alt="{{ $thread->creator->name }}"
                     width="25"
                     height="25"
                     class="mr-1">
            <span class="flex">
                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                <span v-text="title"></span>
            </span>
        </div>
    </div>
    <div class="card-body" v-text="body"></div>     
    
    <div class="card-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-secondary" @click="editing = true">Edit</button>
    </div>
</div>