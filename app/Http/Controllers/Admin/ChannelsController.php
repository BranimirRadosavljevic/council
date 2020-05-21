<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ChannelsController extends Controller
{
    public function index()
    {
        $channels = Channel::withCount('threads')->get();
        return view('admin.channels.index', compact('channels'));
    }

    public function create()
    {
        return view('admin.channels.create');
    }

    public function store()
    {
        $channel = Channel::create(
            request()->validate([
                'name' => 'required|unique:channels',
                'description' => 'required',
            ])
        );

        cache()->forget('channels');

        if (request()->wantsJson()) {
            return response($channel, 201);
        }

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been created!');
    }

    public function edit(Channel $channel)
    {
        //dd(compact('channel'));
        return view('admin.channels.edit', compact('channel'));
    }

    public function update(Channel $channel)
    {
        $channel->update(
            request()->validate([
                'name' => ['required', Rule::unique('channels')->ignore($channel->id)],
                'description' => 'required',
                'archived' => 'required|boolean'
            ])
        );

        // dd(request('name'));    

        Cache::forget('channels');

        if (request()->wantsJson()) {
            return response($channel, 200);
        }

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been updated!');
    }
}
