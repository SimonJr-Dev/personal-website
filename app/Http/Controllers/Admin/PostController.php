<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::latest()->paginate(15)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.posts.create', [
            'post' => new Post(['is_published' => false]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePost($request);

        $post = new Post;
        $this->fill($post, $validated, $request);
        $post->slug = Post::uniqueSlug($validated['title']);
        $post->save();

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post created.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $this->validatePost($request);

        if ($post->title !== $validated['title']) {
            $post->slug = Post::uniqueSlug($validated['title'], $post->id);
        }

        $this->fill($post, $validated, $request);
        $post->save();

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $this->deleteImage($post);
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('status', 'Post deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'content' => ['required', 'string', 'max:20000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    protected function fill(Post $post, array $validated, Request $request): void
    {
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->is_published = $request->boolean('is_published');

        // Publishing without an explicit date means "now"; unpublishing clears it.
        if ($post->is_published) {
            $post->published_at = $validated['published_at'] ?? $post->published_at ?? now();
        } else {
            $post->published_at = $validated['published_at'] ?? null;
        }

        if ($request->boolean('remove_image')) {
            $this->deleteImage($post);
            $post->image_path = null;
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($post);
            $post->image_path = $request->file('image')->store('posts', 'public');
        }
    }

    protected function deleteImage(Post $post): void
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
    }
}
