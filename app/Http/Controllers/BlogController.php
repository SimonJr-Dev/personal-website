<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->latest('published_at')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    public function show(string $slug)
    {
        // Resolved through the published scope so drafts and scheduled posts
        // 404 instead of leaking on a guessed slug.
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        return view('blog.show', [
            'post' => $post,
        ]);
    }
}
