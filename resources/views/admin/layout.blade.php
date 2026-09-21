@php
    use App\Support\AdminCredentials;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin') — MS.</title>

    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    <div class="admin">

        <aside class="sidebar" id="sidebar">

            <div class="sidebar-brand">MS<span>.</span> Admin</div>

            <div class="sidebar-label">Manage</div>

            <nav class="sidebar-nav">

                <a href="{{ route('admin.dashboard') }}" @class(['is-active' => request()->routeIs('admin.dashboard')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 10.5 12 3l9 7.5" />
                        <path d="M5 10v10h14V10" />
                        <path d="M10 21v-6h4v6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.posts.index') }}" @class(['is-active' => request()->routeIs('admin.posts.*')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 5a2 2 0 0 1 2-2h8l6 6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z" />
                        <path d="M14 3v6h6" />
                        <path d="M9 14h6" />
                        <path d="M9 18h4" />
                    </svg>
                    Blog posts
                </a>

                <a href="{{ route('admin.settings') }}" @class(['is-active' => request()->routeIs('admin.settings')])>
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-2.9 1.2 2 2 0 1 1-4 0 1.7 1.7 0 0 0-2.9-1.2l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1A1.7 1.7 0 0 0 3 15a2 2 0 1 1 0-4 1.7 1.7 0 0 0 1.2-2.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1A1.7 1.7 0 0 0 10 4.6a2 2 0 1 1 4 0 1.7 1.7 0 0 0 2.9 1.2l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1A1.7 1.7 0 0 0 21 11a2 2 0 1 1 0 4z" />
                    </svg>
                    Settings
                </a>

            </nav>

            <div class="sidebar-foot">

                <div class="sidebar-user">
                    <strong>Signed in as</strong>
                    {{ AdminCredentials::email() }}
                </div>

                <a class="view-site" href="{{ route('home') }}" target="_blank" rel="noopener">
                    View site &nearr;
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="logout" type="submit">Sign out</button>
                </form>

            </div>

        </aside>

        <div class="sidebar-scrim" id="sidebarScrim"></div>

        <main class="admin-main">

            <div class="admin-topbar">

                <button class="nav-toggle" id="navToggle" type="button" aria-label="Toggle navigation"
                    aria-expanded="false" aria-controls="sidebar">
                    &#9776;
                </button>

                <div class="sidebar-brand" style="padding:0">MS<span>.</span> Admin</div>

            </div>

            <div class="page-head">

                <div>
                    <h1>@yield('heading')</h1>
                    @hasSection('subheading')
                        <p class="meta">@yield('subheading')</p>
                    @endif
                </div>

                @yield('page-actions')

            </div>

            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif

            <div class="content">
                @yield('content')
            </div>

        </main>

    </div>

    <script src="{{ asset('js/admin.js') }}"></script>

</body>

</html>
