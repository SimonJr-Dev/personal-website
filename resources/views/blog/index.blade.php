@extends('layouts.public')

@section('title', 'Blog — Marco L. Simon Jr.')
@section('description', 'Notes on IT work, administrative operations, and things I am building.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endpush

@section('content')

    <div class="blog-main">

        <header class="blog-header">

            <div class="eyebrow">
                <span class="status-dot"></span>
                Blog
            </div>

            <h1>Notes &amp; updates</h1>

            <p>
                Things I am learning, building, and figuring out — written down as I go.
            </p>

        </header>

        @if ($posts->isEmpty())

            <div class="empty-state">

                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 5a2 2 0 0 1 2-2h8l6 6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z" />
                    <path d="M14 3v6h6" />
                    <path d="M9 14h6" />
                    <path d="M9 18h4" />
                </svg>

                <h2>No posts yet</h2>

                <p>
                    Nothing has been published here yet. Check back soon.
                </p>

            </div>

        @else

            <div class="feed" id="feed">
                @foreach ($posts as $post)
                    @include('blog.partials.post-card', ['post' => $post])
                @endforeach
            </div>

            <div class="feed-more" id="feedMore">
                @if ($posts->hasMorePages())
                    <a class="load-more" id="loadMore" href="{{ $posts->nextPageUrl() }}" rel="next">
                        Load more posts
                    </a>
                @else
                    <span class="feed-end">You have reached the end</span>
                @endif
            </div>

        @endif

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/blog.js') }}"></script>
@endpush
