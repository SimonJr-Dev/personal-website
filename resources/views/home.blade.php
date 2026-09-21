<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Marco L. Simon Jr. — IT Developer & Admin Support</title>

    <meta name="description"
        content="Portfolio of Marco L. Simon Jr. — IT Developer and Administrative Support.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Reset, design tokens, navigation and footer are shared with the blog. --}}
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">

    <style>


        /* =========================================
           CURSOR
        ========================================= */

        .cursor {
            position: fixed;

            width: 12px;
            height: 12px;

            border-radius: 50%;

            background: var(--accent);

            pointer-events: none;

            z-index: 9999;

            transform: translate(-50%, -50%);

            mix-blend-mode: difference;

            transition:
                width .25s ease,
                height .25s ease;
        }

        .cursor.large {
            width: 60px;
            height: 60px;
        }


        /* =========================================
           HERO
        ========================================= */

        .hero {
            min-height: 100vh;

            padding: 150px 7vw 80px;

            display: grid;

            grid-template-columns: 1.15fr .85fr;

            align-items: center;

            gap: 70px;

            position: relative;
        }

        .hero-left {
            position: relative;
            z-index: 2;
        }

        .eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;

            margin-bottom: 25px;

            color: #888;

            font-family: "DM Mono", monospace;
            font-size: 10px;

            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .status-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: var(--accent);

            box-shadow: 0 0 18px rgba(184,255,85,.6);
        }

        .hero h1 {
            max-width: 950px;

            font-size: clamp(65px, 9vw, 145px);

            line-height: .86;

            letter-spacing: -.075em;

            font-weight: 800;
        }

        .hero h1 .outline {
            color: transparent;

            -webkit-text-stroke: 1px rgba(255,255,255,.65);
        }

        .hero-description {
            max-width: 580px;

            margin-top: 38px;

            color: #929292;

            font-size: 17px;

            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 18px;

            margin-top: 35px;
        }

        .button-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 15px 23px;

            background: var(--accent);
            color: #0a0a0a;

            border-radius: 11px;

            font-family: "DM Mono", monospace;
            font-size: 10px;

            text-transform: uppercase;

            transition: .3s ease;
        }

        .button-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(184,255,85,.15);
        }

        .button-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 15px 20px;

            border: 1px solid var(--line);
            border-radius: 11px;

            color: #aaa;

            font-family: "DM Mono", monospace;
            font-size: 10px;

            text-transform: uppercase;

            transition: .3s ease;
        }

        .button-secondary:hover {
            color: white;
            border-color: rgba(255,255,255,.3);
        }


        /* =========================================
           HERO IMAGE
        ========================================= */

        .hero-image-wrap {
            position: relative;

            display: flex;
            justify-content: center;

            perspective: 1000px;
        }

        .hero-image-frame {
            position: relative;

            width: min(100%, 460px);

            aspect-ratio: 4 / 5;

            overflow: hidden;

            border-radius: 25px;

            background: #151515;

            border: 1px solid rgba(255,255,255,.12);

            transform: rotate(2deg);

            transition: transform .7s cubic-bezier(.2,.8,.2,1);
        }

        .hero-image-frame:hover {
            transform: rotate(0deg) scale(1.015);
        }

        .hero-image-frame img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            transition: transform 1s cubic-bezier(.2,.8,.2,1);
        }

        .hero-image-frame:hover img {
            transform: scale(1.05);
        }

        .image-label {
            position: absolute;

            left: 18px;
            bottom: 18px;

            padding: 9px 12px;

            background: rgba(0,0,0,.65);

            border: 1px solid rgba(255,255,255,.12);

            border-radius: 8px;

            backdrop-filter: blur(10px);

            font-family: "DM Mono", monospace;
            font-size: 9px;

            text-transform: uppercase;
        }


        /* =========================================
           MARQUEE
        ========================================= */

        .marquee {
            width: 100%;

            overflow: hidden;

            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);

            padding: 18px 0;

            background: #0d0d0d;
        }

        .marquee-track {
            display: flex;
            width: max-content;

            animation: marquee 25s linear infinite;
        }

        .marquee-item {
            padding: 0 35px;

            font-size: 12px;

            font-family: "DM Mono", monospace;

            text-transform: uppercase;

            color: #686868;
        }

        .marquee-item span {
            color: var(--accent);
        }

        @keyframes marquee {

            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }

        }


        /* =========================================
           GENERAL SECTION
        ========================================= */

        section {
            padding: 150px 7vw;
        }

        .section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

            gap: 40px;

            margin-bottom: 70px;
        }

        .section-number {
            margin-bottom: 13px;

            color: var(--accent);

            font-family: "DM Mono", monospace;

            font-size: 10px;
        }

        .section-title {
            font-size: clamp(42px, 6vw, 85px);

            line-height: .95;

            letter-spacing: -.06em;
        }

        .section-description {
            max-width: 390px;

            color: var(--muted);

            font-size: 14px;

            line-height: 1.7;
        }


        /* =========================================
           ABOUT
        ========================================= */

        .about-grid {

            display: grid;

            grid-template-columns: .75fr 1.25fr;

            gap: 90px;

            align-items: center;
        }

        .about-image {
            position: relative;

            max-width: 430px;

            overflow: hidden;

            border-radius: 20px;

            border: 1px solid var(--line);
        }

        .about-image img {
            width: 100%;
            aspect-ratio: 4 / 5;

            object-fit: cover;

            transition: transform .8s ease;
        }

        .about-image:hover img {
            transform: scale(1.04);
        }

        .about-copy h3 {
            max-width: 700px;

            font-size: clamp(32px, 4vw, 58px);

            line-height: 1.05;

            letter-spacing: -.05em;
        }

        .about-copy p {
            max-width: 650px;

            margin-top: 28px;

            color: #898989;

            font-size: 16px;

            line-height: 1.8;
        }

        .stats {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 20px;

            margin-top: 45px;

            border-top: 1px solid var(--line);

            padding-top: 25px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;

            letter-spacing: -.05em;
        }

        .stat-label {
            margin-top: 6px;

            color: #666;

            font-family: "DM Mono", monospace;

            font-size: 9px;

            text-transform: uppercase;
        }


        /* =========================================
           SERVICES
        ========================================= */

        .services {
            border-top: 1px solid var(--line);
        }

        .service-list {
            border-top: 1px solid var(--line);
        }

        .service {

            display: grid;

            grid-template-columns: 80px 1fr 100px;

            align-items: center;

            gap: 25px;

            padding: 35px 0;

            border-bottom: 1px solid var(--line);

            transition: .4s ease;
        }

        .service:hover {
            padding-left: 15px;
        }

        .service-number {
            color: #555;

            font-family: "DM Mono", monospace;

            font-size: 11px;
        }

        .service h3 {
            font-size: clamp(25px, 3vw, 45px);

            letter-spacing: -.04em;
        }

        .service p {
            margin-top: 7px;

            color: #666;

            font-size: 13px;
        }

        .service-arrow {

            justify-self: end;

            width: 45px;
            height: 45px;

            display: grid;
            place-items: center;

            border: 1px solid var(--line);

            border-radius: 50%;

            transition: .4s ease;
        }

        .service:hover .service-arrow {

            background: var(--accent);
            color: black;

            transform: rotate(45deg);

        }


        /* =========================================
           PROJECTS
        ========================================= */

        .projects {
            background: #0c0c0c;
        }

        .project {

            margin-bottom: 110px;
        }

        .project:last-child {
            margin-bottom: 0;
        }

        .project-top {

            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            margin-bottom: 25px;
        }

        .project-category {

            color: var(--accent);

            font-family: "DM Mono", monospace;

            font-size: 10px;

            text-transform: uppercase;
        }

        .project-year {

            color: #555;

            font-family: "DM Mono", monospace;

            font-size: 10px;
        }

        .project-title {

            font-size: clamp(38px, 6vw, 80px);

            line-height: .95;

            letter-spacing: -.065em;
        }

        .project-description {

            max-width: 620px;

            margin-top: 18px;

            color: #858585;

            line-height: 1.7;

            font-size: 14px;

        }

        /* PROJECT GALLERY */

        .project-gallery {

            display: grid;

            grid-template-columns: 1.45fr .8fr;

            gap: 15px;

            margin-top: 35px;
        }

        .project-image {

            position: relative;

            overflow: hidden;

            background: #151515;

            border-radius: 18px;

            border: 1px solid var(--line);

        }

        .project-image.large {
            aspect-ratio: 16 / 10;
        }

        .project-image.small {
            aspect-ratio: 16 / 10;
        }

        .project-image img {

            width: 100%;
            height: 100%;

            object-fit: cover;

            transition:
                transform .8s cubic-bezier(.2,.8,.2,1),
                filter .5s ease;

            cursor: zoom-in;

        }

        .project-image:hover img {

            transform: scale(1.06);

            filter: brightness(.72);

        }

        .image-overlay {

            position: absolute;

            inset: 0;

            display: flex;

            align-items: flex-end;

            padding: 22px;

            opacity: 0;

            transition: .4s ease;

            background: linear-gradient(
                transparent 50%,
                rgba(0,0,0,.7)
            );

        }

        .project-image:hover .image-overlay {
            opacity: 1;
        }

        .image-overlay span {

            padding: 9px 12px;

            background: white;
            color: black;

            border-radius: 7px;

            font-family: "DM Mono", monospace;

            font-size: 9px;

            text-transform: uppercase;

        }

        .project-info {

            display: flex;

            flex-wrap: wrap;

            gap: 9px;

            margin-top: 20px;

        }

        .tag {

            padding: 8px 11px;

            border: 1px solid var(--line);

            border-radius: 7px;

            color: #888;

            font-family: "DM Mono", monospace;

            font-size: 9px;

        }


        /* =========================================
           CERTIFICATE
        ========================================= */

        .certificate {

            margin-top: 15px;

            display: grid;

            grid-template-columns: 1fr .35fr;

            gap: 15px;

        }

        .certificate-image {

            overflow: hidden;

            border-radius: 16px;

            border: 1px solid var(--line);

            background: #151515;

            max-width: 700px;

            margin: 0 auto;

            box-shadow: 0 25px 60px rgba(0,0,0,.28);

        }

        .project:nth-child(1) .certificate-image {
            transform: rotate(180deg);
        }

        .project:nth-child(2) .certificate-image {
            transform: rotate(270deg);
        }

        .certificate-image img {

            width: 100%;

            height: 420px;

            object-fit: contain;

            padding: 20px;

            transition: transform .6s ease;

            cursor: zoom-in;

        }

        .certificate-image:hover img {
            transform: scale(1.04);
        }

        .hero-image-frame img,
        .about-image img {
            cursor: zoom-in;
        }

        .lightbox-overlay {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            background: rgba(5,5,5,.82);
            backdrop-filter: blur(12px);
            opacity: 0;
            visibility: hidden;
            transition: opacity .25s ease, visibility .25s ease;
        }

        .lightbox-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .lightbox-panel {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: min(92vw, 1100px);
            max-height: 92vh;
        }

        .lightbox-panel img {
            max-width: 100%;
            max-height: 92vh;
            object-fit: contain;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,.12);
            background: #111;
            box-shadow: 0 25px 80px rgba(0,0,0,.45);
        }

        .lightbox-close {
            position: absolute;
            top: -18px;
            right: -18px;
            width: 42px;
            height: 42px;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50%;
            background: rgba(0,0,0,.75);
            color: white;
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
        }


        /* =========================================
           SKILLS
        ========================================= */

        .skills-grid {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 12px;
        }

        .skill {

            min-height: 130px;

            padding: 22px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            border: 1px solid var(--line);

            border-radius: 15px;

            background: var(--surface);

            transition: .35s ease;

        }

        .skill:hover {

            transform: translateY(-7px);

            border-color: rgba(184,255,85,.3);

        }

        .skill-number {

            color: #555;

            font-family: "DM Mono", monospace;

            font-size: 9px;

        }

        .skill-name {

            font-size: 16px;

            font-weight: 600;

        }


        /* =========================================
           EXPERIENCE
        ========================================= */

        .experience {
            border-top: 1px solid var(--line);
        }

        .experience-item {

            display: grid;

            grid-template-columns: 180px 1fr 150px;

            gap: 40px;

            padding: 35px 0;

            border-bottom: 1px solid var(--line);

        }

        .experience-date {

            color: #666;

            font-family: "DM Mono", monospace;

            font-size: 10px;
        }

        .experience-title {

            font-size: 25px;

            letter-spacing: -.03em;
        }

        .experience-company {

            margin-top: 8px;

            color: var(--accent);

            font-family: "DM Mono", monospace;

            font-size: 10px;

            text-transform: uppercase;
        }

        .experience-text {

            color: #777;

            font-size: 12px;

            line-height: 1.6;
        }


        /* =========================================
           CONTACT
        ========================================= */

        .contact {

            min-height: 75vh;

            display: flex;

            flex-direction: column;

            justify-content: center;

            background: #0b0b0b;

        }

        .contact-title {

            max-width: 1100px;

            font-size: clamp(55px, 10vw, 145px);

            line-height: .86;

            letter-spacing: -.08em;
        }

        .contact-title span {
            color: var(--accent);
        }

        .contact-bottom {

            display: flex;

            justify-content: space-between;

            align-items: flex-end;

            margin-top: 80px;

            padding-top: 25px;

            border-top: 1px solid var(--line);

        }

        .contact-links {

            display: flex;

            flex-wrap: wrap;

            gap: 12px;
        }

        .contact-link {

            padding: 13px 17px;

            border: 1px solid var(--line);

            border-radius: 9px;

            color: #aaa;

            font-family: "DM Mono", monospace;

            font-size: 9px;

            text-transform: uppercase;

            transition: .3s ease;

        }

        .contact-link:hover {

            color: black;

            background: var(--accent);

            border-color: var(--accent);

        }

        .email {

            color: #888;

            font-family: "DM Mono", monospace;

            font-size: 10px;
        }


        /* =========================================
           REVEAL ANIMATION
        ========================================= */

        .reveal {

            opacity: 0;

            transform: translateY(45px);

            transition:
                opacity .8s ease,
                transform .8s cubic-bezier(.2,.8,.2,1);

        }

        .reveal.visible {

            opacity: 1;

            transform: translateY(0);

        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 900px) {

            .hero {

                grid-template-columns: 1fr;

                padding-top: 140px;

                gap: 60px;

            }

            .hero-image-wrap {
                order: -1;
            }

            .hero-image-frame {
                max-width: 330px;
            }

            .about-grid {
                grid-template-columns: 1fr;
            }

            .about-image {
                max-width: 360px;
            }

            .skills-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .experience-item {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .project-gallery {
                grid-template-columns: 1fr;
            }

            .certificate {
                grid-template-columns: 1fr;
            }

            .contact-bottom {
                flex-direction: column;
                align-items: flex-start;
                gap: 25px;
            }
        }


        @media (max-width: 600px) {

            section {
                padding: 100px 6vw;
            }

            .hero {
                padding: 125px 6vw 70px;
            }

            .hero h1 {
                font-size: clamp(54px, 16vw, 90px);
            }

            .hero-description {
                font-size: 14px;
            }

            .hero-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .section-heading {
                display: block;
            }

            .section-description {
                margin-top: 25px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .service {
                grid-template-columns: 45px 1fr 45px;
            }

            .service p {
                display: none;
            }

            .skills-grid {
                grid-template-columns: 1fr 1fr;
            }

            .skill {
                min-height: 110px;
            }

            .project {
                margin-bottom: 75px;
            }

            .project-title {
                font-size: 42px;
            }

            .contact-title {
                font-size: 62px;
            }

            footer {
                flex-direction: column;
                gap: 10px;
            }

        }

    </style>
</head>


<body>


    <!-- =========================================
         CUSTOM CURSOR
    ========================================= -->

    <div class="cursor"></div>


    <!-- =========================================
         NAVIGATION
    ========================================= -->

    @include('partials.nav')


    <!-- =========================================
         HERO
    ========================================= -->

    <main>

        <section class="hero" id="home">

            <div class="hero-left reveal">

                <div class="eyebrow">

                    <span class="status-dot"></span>

                    Fresh IT Graduate · BS Information Technology

                </div>


                <h1>

                    {{ $site['hero_name'] ?? 'Marco' }}
                    <br>

                    <span class="outline">{{ $site['hero_last_name'] ?? 'Simon' }}</span>

                </h1>


                <p class="hero-description">

                    {{ $site['hero_description'] ?? 'I help teams stay organized, build useful digital tools, and move everyday work forward with care and consistency.' }}

                    <br><br>

                    <strong style="color:white;">
                        {{ $site['hero_role'] ?? 'IT Developer · Administrative Support' }}
                    </strong>

                </p>


                <div class="hero-actions">

                    <a href="#projects" class="button-primary">
                        View my work
                    </a>

                    <a href="#contact" class="button-secondary">
                        Contact me →
                    </a>

                </div>

            </div>


            <div class="hero-image-wrap reveal">

                <div class="hero-image-frame">

                    <img
                        src="{{ asset('images/formal.jpg') }}"
                        alt="Marco L. Simon Jr."
                    >

                    <div class="image-label">
                        Marco L. Simon Jr.
                    </div>

                </div>

            </div>

        </section>


        <!-- =========================================
             MARQUEE
        ========================================= -->

        <div class="marquee">

            <div class="marquee-track">

                <div class="marquee-item">
                    Laravel <span>✦</span>
                </div>

                <div class="marquee-item">
                    Data Tools <span>✦</span>
                </div>

                <div class="marquee-item">
                    Flutter <span>✦</span>
                </div>

                <div class="marquee-item">
                    Microsoft Office <span>✦</span>
                </div>

                <div class="marquee-item">
                    Google Workspace <span>✦</span>
                </div>

                <div class="marquee-item">
                    UI/UX Design <span>✦</span>
                </div>

                <div class="marquee-item">
                    Administrative Support <span>✦</span>
                </div>


                <!-- duplicate -->

                <div class="marquee-item">
                    Laravel <span>✦</span>
                </div>

                <div class="marquee-item">
                    MySQL <span>✦</span>
                </div>

                <div class="marquee-item">
                    Flutter <span>✦</span>
                </div>

                <div class="marquee-item">
                    Microsoft Office <span>✦</span>
                </div>

                <div class="marquee-item">
                    Google Workspace <span>✦</span>
                </div>

                <div class="marquee-item">
                    UI/UX Design <span>✦</span>
                </div>

                <div class="marquee-item">
                    Administrative Support <span>✦</span>
                </div>

            </div>

        </div>


        <!-- =========================================
             ABOUT
        ========================================= -->

        <section id="about">

            <div class="section-heading reveal">

                <div>

                    <div class="section-number">
                        01 — About
                    </div>

                    <h2 class="section-title">
                        A practical mix of<br>
                        technology & reliability.
                    </h2>

                </div>

                <p class="section-description">

                    {{ $site['about_text'] ?? 'A recent Bachelor of Science in Information Technology graduate with hands-on experience in development, administrative operations, and project coordination.' }}

                </p>

            </div>


            <div class="about-grid">

                <div class="about-image reveal">

                    <img
                        src="{{ asset('images/2x2-pic.jpg') }}"
                        alt="Marco Simon formal portrait"
                    >

                </div>


                <div class="about-copy reveal">

                    <h3>
                        Building useful things
                        while keeping the work organized.
                    </h3>

                    <p>

                        I bring together technical skills and administrative
                        discipline to solve practical problems. My experience
                        includes web development, UI/UX design, document
                        processing, records management, data entry, and
                        team coordination.

                    </p>


                    <div class="stats">

                        <div>

                            <div class="stat-number">
                                486
                            </div>

                            <div class="stat-label">
                                Practicum Hours
                            </div>

                        </div>


                        <div>

                            <div class="stat-number">
                                BS IT
                            </div>

                            <div class="stat-label">
                                Urdaneta City University
                            </div>

                        </div>


                        <div>

                            <div class="stat-number">
                                2026
                            </div>

                            <div class="stat-label">
                                Graduate
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- =========================================
             SERVICES
        ========================================= -->

        <section class="services" id="services">

            <div class="section-heading reveal">

                <div>

                    <div class="section-number">
                        02 — Services
                    </div>

                    <h2 class="section-title">
                        What I do.
                    </h2>

                </div>

                <p class="section-description">

                    Practical technical and administrative support
                    for everyday business and digital needs.

                </p>

            </div>


            <div class="service-list">


                <div class="service reveal">

                    <div class="service-number">
                        01
                    </div>

                    <div>

                        <h3>
                            Web Development
                        </h3>

                        <p>
                            Laravel, PHP, MySQL and responsive web systems.
                        </p>

                    </div>

                    <div class="service-arrow">
                        ↗
                    </div>

                </div>


                <div class="service reveal">

                    <div class="service-number">
                        02
                    </div>

                    <div>

                        <h3>
                            UI/UX Design
                        </h3>

                        <p>
                            Clean interfaces and user-focused digital experiences.
                        </p>

                    </div>

                    <div class="service-arrow">
                        ↗
                    </div>

                </div>


                <div class="service reveal">

                    <div class="service-number">
                        03
                    </div>

                    <div>

                        <h3>
                            Administrative Support
                        </h3>

                        <p>
                            Data entry, document management, records and organization.
                        </p>

                    </div>

                    <div class="service-arrow">
                        ↗
                    </div>

                </div>


            </div>

        </section>


        <!-- =========================================
             PROJECTS
        ========================================= -->

        <section class="projects" id="projects">

            <div class="section-heading reveal">

                <div>

                    <div class="section-number">
                        03 — Selected Work
                    </div>

                    <h2 class="section-title">
                        Things I've<br>
                        worked on.
                    </h2>

                </div>

                <p class="section-description">

                    A selection of academic, professional, and personal
                    work built through hands-on experience.

                </p>

            </div>


            <!-- =====================================
                 TESDA PROJECT
            ====================================== -->

            <article class="project reveal">

                <div class="project-top">

                    <div class="project-category">
                        Capstone Project
                    </div>

                    <div class="project-year">
                        2025 — 2026
                    </div>

                </div>


                <h3 class="project-title">
                    TESDA Evaluation &<br>
                    Management System
                </h3>


                <p class="project-description">

                    A multi-platform system developed to support
                    evaluation and management operations. I served as
                    project leader and frontend developer, helping
                    coordinate the team and build responsive interfaces.

                </p>


                <div class="project-gallery">

                    <div class="project-image large">

                        <img
                            src="{{ asset('images/tesda-pic-1.jpg') }}"
                            alt="TESDA project presentation"
                            loading="lazy"
                        >

                        <div class="image-overlay">

                            <span>
                                View Project
                            </span>

                        </div>

                    </div>


                    <div class="project-image small">

                        <img
                            src="{{ asset('images/tesda-pic-2.jpg') }}"
                            alt="TESDA project team"
                            loading="lazy"
                        >

                        <div class="image-overlay">

                            <span>
                                Project Photo
                            </span>

                        </div>

                    </div>

                </div>


                <div class="project-info">

                    <span class="tag">
                        Laravel
                    </span>

                    <span class="tag">
                        PHP
                    </span>

                    <span class="tag">
                        MySQL
                    </span>

                    <span class="tag">
                        Flutter
                    </span>

                    <span class="tag">
                        UI/UX
                    </span>

                    <span class="tag">
                        Team Leadership
                    </span>

                </div>


                <div class="certificate">

                    <div class="certificate-image">

                        <img
                            src="{{ asset('images/tesda-pic-certif.jpg') }}"
                            alt="TESDA Certificate"
                            loading="lazy"
                        >

                    </div>

                </div>

            </article>


            <!-- =====================================
                 PCIC
            ====================================== -->

            <article class="project reveal">

                <div class="project-top">

                    <div class="project-category">
                        Practicum · PCIC Region I
                    </div>

                    <div class="project-year">
                        2026
                    </div>

                </div>


                <h3 class="project-title">
                    Administrative<br>
                    Operations
                </h3>


                <p class="project-description">

                    During my 486-hour practicum at the Philippine Crop
                    Insurance Corporation, I assisted with insurance
                    claims, document processing, filing, records
                    management, and client transactions.

                </p>


                <div class="project-gallery">

                    <div class="project-image large">

                        <img
                            src="{{ asset('images/pcic-pic-1.jpg') }}"
                            alt="PCIC practicum"
                            loading="lazy"
                        >

                        <div class="image-overlay">

                            <span>
                                PCIC Region I
                            </span>

                        </div>

                    </div>


                    <div class="project-image small">

                        <img
                            src="{{ asset('images/pcic-pic-2.jpg') }}"
                            alt="PCIC practicum team"
                            loading="lazy"
                        >

                        <div class="image-overlay">

                            <span>
                                Experience
                            </span>

                        </div>

                    </div>

                </div>


                <div class="project-info">

                    <span class="tag">
                        Document Processing
                    </span>

                    <span class="tag">
                        Records Management
                    </span>

                    <span class="tag">
                        Data Entry
                    </span>

                    <span class="tag">
                        Administrative Support
                    </span>

                </div>


                <div class="certificate">

                    <div class="certificate-image">

                        <img
                            src="{{ asset('images/pcic-pic-certif.jpg') }}"
                            alt="PCIC Certificate"
                            loading="lazy"
                        >

                    </div>

                </div>

            </article>


            <!-- =====================================
                 MORE WORK
            ====================================== -->

            <article class="project reveal">

                <div class="project-top">

                    <div class="project-category">
                        Personal Work
                    </div>

                    <div class="project-year">
                        Ongoing
                    </div>

                </div>


                <h3 class="project-title">
                    More work<br>
                    coming soon.
                </h3>


                <p class="project-description">

                    More projects, experiments, and professional work
                    will be added here as I continue building.

                </p>


                <div class="project-image"
                     style="margin-top:35px; aspect-ratio:16/7;">

                    <img
                        src="{{ asset('images/more-work-coming-soon.jpg') }}"
                        alt="More work coming soon"
                        loading="lazy"
                    >

                </div>

            </article>

        </section>


        <!-- =========================================
             TOOLS
        ========================================= -->

        <section id="skills">

            <div class="section-heading reveal">

                <div>

                    <div class="section-number">
                        04 — Toolkit
                    </div>

                    <h2 class="section-title">
                        Tools I use.
                    </h2>

                </div>

                <p class="section-description">

                    A combination of development, productivity,
                    design, and collaboration tools.

                </p>

            </div>


            <div class="skills-grid">


                <div class="skill reveal">

                    <span class="skill-number">
                        01
                    </span>

                    <span class="skill-name">
                        Laravel
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        02
                    </span>

                    <span class="skill-name">
                        PHP
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        03
                    </span>

                    <span class="skill-name">
                        MySQL
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        04
                    </span>

                    <span class="skill-name">
                        JavaScript
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        05
                    </span>

                    <span class="skill-name">
                        Flutter
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        06
                    </span>

                    <span class="skill-name">
                        Microsoft Excel
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        07
                    </span>

                    <span class="skill-name">
                        Microsoft Word
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        08
                    </span>

                    <span class="skill-name">
                        PowerPoint
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        09
                    </span>

                    <span class="skill-name">
                        Google Workspace
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        10
                    </span>

                    <span class="skill-name">
                        Canva
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        11
                    </span>

                    <span class="skill-name">
                        Figma
                    </span>

                </div>


                <div class="skill reveal">

                    <span class="skill-number">
                        12
                    </span>

                    <span class="skill-name">
                        AI Tools
                    </span>

                </div>


            </div>

        </section>


        <!-- =========================================
             EXPERIENCE
        ========================================= -->

        <section class="experience" id="experience">

            <div class="section-heading reveal">

                <div>

                    <div class="section-number">
                        05 — Experience
                    </div>

                    <h2 class="section-title">
                        Where I've<br>
                        learned.
                    </h2>

                </div>

            </div>


            <div class="experience-item reveal">

                <div class="experience-date">
                    2026
                </div>

                <div>

                    <h3 class="experience-title">
                        Student Intern
                    </h3>

                    <div class="experience-company">
                        Philippine Crop Insurance Corporation · Region I
                    </div>

                </div>

                <div class="experience-text">

                    Insurance claims,
                    document processing,
                    filing, records management,
                    and client transactions.

                </div>

            </div>


            <div class="experience-item reveal">

                <div class="experience-date">
                    2025 — 2026
                </div>

                <div>

                    <h3 class="experience-title">
                        Capstone Project Leader /
                        Frontend Developer
                    </h3>

                    <div class="experience-company">
                        TESDA Evaluation & Management System
                    </div>

                </div>

                <div class="experience-text">

                    Team coordination,
                    responsive interfaces,
                    Laravel,
                    MySQL,
                    Flutter,
                    and project development.

                </div>

            </div>

        </section>


        <!-- =========================================
             CONTACT
        ========================================= -->

        <section class="contact" id="contact">

            <div class="section-number reveal">
                06 — Contact
            </div>


            <h2 class="contact-title reveal">

                Let's build
                <br>

                something <span>useful.</span>

            </h2>


            <div class="contact-bottom reveal">

                <div class="contact-links">

                    <a
                        href="mailto:SimonJrDev@gmail.com"
                        class="contact-link"
                    >
                        Email
                    </a>


                    <a
                        href="https://www.facebook.com/cmon3k"
                        target="_blank"
                        class="contact-link"
                    >
                        Facebook
                    </a>


                    <a
                        href="https://marcosimonjr.vercel.app/"
                        target="_blank"
                        class="contact-link"
                    >
                        Current Portfolio
                    </a>

                </div>


                <div class="email">
                    SimonJrDev@gmail.com
                </div>

            </div>

        </section>

    </main>


    <!-- =========================================
         FOOTER
    ========================================= -->

    @include('partials.footer')


    <!-- =========================================
         JAVASCRIPT
    ========================================= -->

    {{-- Nav scroll state and the mobile drawer are shared with the blog. --}}
    <script src="{{ asset('js/site.js') }}"></script>

    <script>

        /* =========================================
           CUSTOM CURSOR
        ========================================= */

        const cursor = document.querySelector(".cursor");

        if (window.innerWidth > 900) {

            document.addEventListener("mousemove", function(e) {

                cursor.style.left = e.clientX + "px";
                cursor.style.top = e.clientY + "px";

            });


            document.querySelectorAll("a, button, .project-image, .skill, .service")
                .forEach(element => {

                    element.addEventListener("mouseenter", () => {
                        cursor.classList.add("large");
                    });

                    element.addEventListener("mouseleave", () => {
                        cursor.classList.remove("large");
                    });

                });

        } else {

            cursor.style.display = "none";

        }


        /* =========================================
           SCROLL REVEAL
        ========================================= */

        const revealElements =
            document.querySelectorAll(".reveal");


        const observer = new IntersectionObserver(

            entries => {

                entries.forEach(entry => {

                    if (entry.isIntersecting) {

                        entry.target.classList.add("visible");

                        observer.unobserve(entry.target);

                    }

                });

            },

            {
                threshold: .12
            }

        );


        revealElements.forEach(element => {

            observer.observe(element);

        });


        /* =========================================
           IMAGE PARALLAX
        ========================================= */

        const heroImage =
            document.querySelector(".hero-image-frame");


        window.addEventListener("scroll", () => {

            if (!heroImage) return;

            const scroll = window.scrollY;

            if (scroll < window.innerHeight) {

                heroImage.style.transform =
                    `rotate(2deg) translateY(${scroll * .06}px)`;

            }

        });


        /* =========================================
           LIGHTBOX VIEWER
        ========================================= */

        const lightboxOverlay = document.createElement("div");
        lightboxOverlay.className = "lightbox-overlay";

        const lightboxPanel = document.createElement("div");
        lightboxPanel.className = "lightbox-panel";

        const lightboxImage = document.createElement("img");
        lightboxImage.alt = "Expanded portfolio image";

        const lightboxClose = document.createElement("button");
        lightboxClose.className = "lightbox-close";
        lightboxClose.type = "button";
        lightboxClose.textContent = "×";

        lightboxPanel.appendChild(lightboxImage);
        lightboxPanel.appendChild(lightboxClose);
        lightboxOverlay.appendChild(lightboxPanel);
        document.body.appendChild(lightboxOverlay);

        const openLightbox = (image) => {
            lightboxImage.src = image.src;
            lightboxImage.alt = image.alt || "Expanded project image";
            lightboxOverlay.classList.add("active");
            document.body.style.overflow = "hidden";
        };

        const closeLightbox = () => {
            lightboxOverlay.classList.remove("active");
            document.body.style.overflow = "";
        };

        lightboxClose.addEventListener("click", closeLightbox);

        lightboxOverlay.addEventListener("click", (event) => {
            if (event.target === lightboxOverlay) {
                closeLightbox();
            }
        });

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                closeLightbox();
            }
        });

        document.querySelectorAll(
            ".hero-image-frame img, .about-image img, .project-image img, .certificate-image img"
        ).forEach((image) => {
            image.addEventListener("click", () => openLightbox(image));
        });

    </script>

</body>

</html>