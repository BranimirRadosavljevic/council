{{--Editing the thread--}}
<div class="card mb-2" v-if="editing">
    <div class="card-header">
        <input type="text" v-model="form.title" class="form-control"> 
    </div>

    <div class="card-body">
        <div class="form-group">
            <wysiwyg v-model="form.body"></wysiwyg>
            {{-- <textarea class="form-control" rows="10" v-model="form.body"></textarea> --}}
        </div>
    </div>

    <div class="card-footer">
        <div class="level">
            <button class="btn btn-sm btn-outline-secondary" @click="editing = true" v-show="!editing">Edit</button>
            <button class="btn btn-sm btn-primary mr-2" @click="update">Update</button>
            <button class="btn btn-sm btn-outline-secondary" @click="resetForm">Cancel</button>

            @can('update', $thread)
            <form action="{{$thread->path()}}" method="POST" class="ml-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link">Delete Thread</button>
            </form>
            @endcan
       
        </div>
    </div>
</div>


{{-- Viewing the thread --}}
<div class="card mb-2" v-else>
    <div class="card-header">
        <div class="level">

            <img src="{{ $thread->creator->avatar_path}}" alt="{{$thread->creator->name}}" width="25" height="25" class="mr-1">
            
            <span class="flex">
                <a href="{{route('profile', $thread->creator)}}">{{$thread->creator->name}} ({{$thread->creator->reputation}} XP)</a> posted: <span v-text="title"></span>
            </span>
            
        </div>
    </div>

    <div class="card-body" v-html="body"></div>

    <div class="card-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-sm btn-outline-secondary" @click="editing = true">Edit</button>
    </div>
</div>