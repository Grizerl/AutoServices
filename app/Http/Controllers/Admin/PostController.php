<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.post.index', [
            'post_content' => Post::latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.post.create');
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Post::create([
            'title' => $data['title'],
            'content' => $data['content_post'],
        ]);

        return redirect()->route('post.index')->with('success', 'The post has been created.');
    }

    public function edit(Post $post): View
    {
        return view('admin.post.edit', ['post' => $post]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();

        $post->update([
            'title' => $data['title'],
            'content' => $data['content_post'],
        ]);

        return redirect()->route('post.index')->with('success', 'The post has been updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('post.index')->with('success', 'The post has been deleted.');
    }
}
