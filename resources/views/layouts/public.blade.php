<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Marco L. Simon Jr.')</title>

    <meta name="description" content="@yield('description', 'Portfolio of Marco L. Simon Jr. — IT Developer and Administrative Support.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/site.css') }}">

    @stack('styles')
</head>

<body>

    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('js/site.js') }}"></script>

    @stack('scripts')

</body>

</html>
