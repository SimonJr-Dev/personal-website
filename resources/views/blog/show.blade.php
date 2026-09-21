@extends('layouts.public')

@section('title', $post->title.' — Marco L. Simon Jr.')
@section('description', $post->excerpt(160))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endpush

@section('content')

    @php($author = $post->author())

    <div class="blog-main">

        <article class="post-article" data-post="{{ $post->id }}">

            <a class="back-link" href="{{ route('blog.index') }}">&larr; Back to blog</a>

            <h1>{{ $post->title }}</h1>

            <header class="post-head">

                <img class="post-avatar" src="{{ $author['avatar'] }}" alt="{{ $author['name'] }}">

                <div class="post-author">
                    <span class="post-author-name">{{ $author['name'] }}</span>
                    <time class="post-time" datetime="{{ $post->displayedAt()->toIso8601String() }}">
                        {{ $post->displayedAt()->format('F j, Y') }} · {{ $post->displayedAt()->diffForHumans() }}
                    </time>
                </div>

            </header>

            @if ($post->imageUrl())
                <img class="post-media" src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
            @endif

            <p class="post-content">{{ $post->content }}</p>

            <footer class="post-actions">

                <button class="post-action" type="button" data-toggle="like" aria-pressed="false">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1L12 21l7.7-7.6 1.1-1a5.5 5.5 0 0 0 0-7.8z" />
                    </svg>
                    <span>Like</span>
                </button>

                <button class="post-action" type="button" data-share data-url="{{ route('blog.show', $post->slug) }}"
                    data-title="{{ $post->title }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 12v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7" />
                        <path d="m16 6-4-4-4 4" />
                        <path d="M12 2v14" />
                    </svg>
                    <span>Share</span>
                </button>

                <button class="post-action post-action-save" type="button" data-toggle="save" aria-pressed="false">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" />
                    </svg>
                    <span>Save</span>
                </button>

            </footer>

        </article>

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/blog.js') }}"></script>
@endpush
