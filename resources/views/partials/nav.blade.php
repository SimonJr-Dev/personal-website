@php
    // Section links live on the portfolio page, so they need an absolute path
    // when the nav is rendered anywhere else.
    $section = request()->routeIs('home') ? '' : route('home');
    $onBlog = request()->routeIs('blog.*');
@endphp

<nav class="nav" id="nav">

    <a href="{{ $section }}#home" class="logo">
        MS<span>.</span>
    </a>

    <div class="nav-links">

        <a href="{{ $section }}#about">About</a>

        <a href="{{ route('blog.index') }}" @class(['is-active' => $onBlog])>Blog</a>

        <a href="{{ $section }}#services">Services</a>

        <a href="{{ $section }}#projects">Projects</a>

        <a href="{{ $section }}#skills">Tools</a>

        <a href="{{ $section }}#experience">Experience</a>

    </div>

    <a href="{{ $section }}#contact" class="nav-contact">
        Let's Talk
    </a>

    <button class="menu-button" id="menuButton" type="button" aria-label="Toggle menu" aria-expanded="false"
        aria-controls="mobileMenu">
        &#9776;
    </button>

</nav>


<div class="mobile-menu" id="mobileMenu">

    <a href="{{ $section }}#about">About</a>

    <a href="{{ route('blog.index') }}" @class(['is-active' => $onBlog])>Blog</a>

    <a href="{{ $section }}#services">Services</a>

    <a href="{{ $section }}#projects">Projects</a>

    <a href="{{ $section }}#skills">Tools</a>

    <a href="{{ $section }}#experience">Experience</a>

    <a href="{{ $section }}#contact" class="mobile-menu-cta">
        Let's Talk
    </a>

</div>
