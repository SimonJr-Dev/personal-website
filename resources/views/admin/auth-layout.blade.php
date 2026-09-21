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

    <div class="auth-shell">

        <div class="auth-card">

            <div class="brand">MS<span>.</span> Admin</div>

            <h1>@yield('heading')</h1>

            @if (session('status'))
                <div class="status" style="margin-bottom:16px">{{ session('status') }}</div>
            @endif

            @yield('content')

            <div class="helper">
                <a href="{{ route('home') }}">&larr; Back to site</a>
            </div>

        </div>

    </div>

</body>

</html>
