@extends('admin.layout')

@section('title', 'Blog posts')
@section('heading', 'Blog posts')
@section('subheading', $posts->total().' '.Str::plural('post', $posts->total()).' total')

@section('page-actions')
    <a class="btn btn-accent" href="{{ route('admin.posts.create') }}">New post</a>
@endsection

@section('content')

    <div class="card">

        @if ($posts->isEmpty())

            <div class="admin-empty">
                <h3>No posts yet</h3>
                <p>Write your first post and it will show up on the blog.</p>
                <a class="btn btn-accent" href="{{ route('admin.posts.create') }}">Write a post</a>
            </div>

        @else

            <div class="post-list">

                @foreach ($posts as $post)
                    <div class="post-row">

                        @if ($post->imageUrl())
                            <img class="post-row-thumb" src="{{ $post->imageUrl() }}" alt="">
                        @else
                            <div class="post-row-thumb is-empty">No image</div>
                        @endif

                        <div class="post-row-main">

                            <p class="post-row-title">{{ $post->title }}</p>

                            <div class="post-row-meta">

                                @if (! $post->is_published)
                                    <span class="pill pill-draft">Draft</span>
                                @elseif ($post->published_at && $post->published_at->isFuture())
                                    <span class="pill pill-scheduled">Scheduled</span>
                                @else
                                    <span class="pill pill-live">Live</span>
                                @endif

                                <span>{{ $post->displayedAt()->format('M j, Y') }}</span>

                                <span>/{{ $post->slug }}</span>

                            </div>

                        </div>

                        <div class="post-row-actions">

                            @if ($post->is_published && (! $post->published_at || ! $post->published_at->isFuture()))
                                <a class="btn btn-sm" href="{{ route('blog.show', $post->slug) }}" target="_blank"
                                    rel="noopener">View</a>
                            @endif

                            <a class="btn btn-sm" href="{{ route('admin.posts.edit', $post) }}">Edit</a>

                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                data-confirm="Delete &quot;{{ $post->title }}&quot;? This cannot be undone.">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>

                        </div>

                    </div>
                @endforeach

            </div>

            @include('admin.partials.pagination', ['paginator' => $posts])

        @endif

    </div>

@endsection
