@php
    $author = $post->author();
    $long = $post->isLong();
@endphp

<article class="post-card" data-post="{{ $post->id }}">

    <header class="post-head">

        <img class="post-avatar" src="{{ $author['avatar'] }}" alt="{{ $author['name'] }}">

        <div class="post-author">
            <span class="post-author-name">{{ $author['name'] }}</span>
            <time class="post-time" datetime="{{ $post->displayedAt()->toIso8601String() }}">
                {{ $post->displayedAt()->diffForHumans() }}
            </time>
        </div>

    </header>

    @if ($post->imageUrl())
        <a href="{{ route('blog.show', $post->slug) }}">
            <img class="post-media" src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" loading="lazy">
        </a>
    @endif

    <div class="post-body">

        <h2 class="post-title">
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h2>

        @if ($long)
            <p class="post-content" data-excerpt>{{ $post->excerpt() }}</p>
            <p class="post-content" data-full hidden>{{ $post->content }}</p>
            <button class="read-more" type="button" data-read-more>Read more</button>
        @else
            <p class="post-content">{{ $post->content }}</p>
        @endif

    </div>

    <footer class="post-actions">

        <button class="post-action" type="button" data-toggle="like" aria-pressed="false">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1L12 21l7.7-7.6 1.1-1a5.5 5.5 0 0 0 0-7.8z" />
            </svg>
            <span>Like</span>
        </button>

        <a class="post-action" href="{{ route('blog.show', $post->slug) }}">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.9 8.9 0 0 1-3.8-.9L3 20.7l1.7-5.1a8.4 8.4 0 0 1-.9-3.8 8.4 8.4 0 0 1 8.4-8.4h.5A8.4 8.4 0 0 1 21 11v.5z" />
            </svg>
            <span>Read</span>
        </a>

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
