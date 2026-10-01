<!doctype html>
<html lang="{{ kirby()->language()?->code() ?? 'en' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="@csrf()">

    @php
        $seoPage = page();
        // metaTitle, when set, is authored as a full title (already includes the
        // brand) — don't re-append the site title on top of it.
        $metaTitle = $seoPage->metaTitle()->value();
        $title = $metaTitle ?: $seoPage->title() . ' | ' . site()->title();
        $metaDescription = $seoPage->metaDescription()->value();
        $ogTitle = $seoPage->ogTitle()->or($metaTitle ?: $title)->value();
        $ogDescription = $seoPage->ogDescription()->or($metaDescription)->value();
        $ogImage = $seoPage->ogImage()->toFile() ?? $seoPage->images()->first();
        $noIndex = $seoPage->noIndex()->toBool();
    @endphp

    <title>{{ $title }}</title>

    @if ($metaDescription)
        <meta name="description" content="{{ $metaDescription }}">
    @endif

    @if ($noIndex)
        <meta name="robots" content="noindex, nofollow">
    @endif

    <link rel="canonical" href="{{ $seoPage->url() }}">

    {{-- Open Graph / social sharing --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ site()->title() }}">
    <meta property="og:locale" content="{{ kirby()->language()?->code() === 'es' ? 'es_ES' : 'en_US' }}">
    <meta property="og:url" content="{{ $seoPage->url() }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    @if ($ogDescription)
        <meta property="og:description" content="{{ $ogDescription }}">
    @endif
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage->url() }}">
        <meta property="og:image:width" content="{{ $ogImage->width() }}">
        <meta property="og:image:height" content="{{ $ogImage->height() }}">
    @endif

    <meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    @if ($ogDescription)
        <meta name="twitter:description" content="{{ $ogDescription }}">
    @endif
    @if ($ogImage)
        <meta name="twitter:image" content="{{ $ogImage->url() }}">
    @endif

    @if ($favicon = site()->favicon()->toFile())
        <link rel="icon" href="{{ $favicon->url() }}" type="{{ $favicon->mime() }}">
    @endif

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Pre-hide fade-in targets before first paint, only when JS is on and
         motion is allowed, so GSAP reveals them without a flash. --}}
    <script>
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.classList.add('has-anim');
        }
    </script>
    <style>
        .has-anim [data-fade],
        .has-anim [data-parallax-bottle] { opacity: 0; }
    </style>

    {{-- @font-face kept out of the Vite-bundled CSS so the url() resolves
         against the site origin (works in dev and production). --}}
    <style>
        @font-face {
            font-family: '1669 Elzevir W01';
            src: url('/fonts/1669%20Elzevir%20W01%20Italic.woff2') format('woff2');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Abhaya Libre';
            src: url('/fonts/Abhaya%20Libre%20Medium.woff2') format('woff2');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: '1920 My Toy Print';
            src: url('/fonts/1920%20My%20Toy%20Print%20W00%20Bold.woff2') format('woff2');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
    </style>

    {{-- Site-wide repeating background. Kept out of the Vite-bundled CSS so the
         url() resolves against the site origin (works in dev and production);
         WebP is served where supported, with a PNG fallback. --}}
    <style>
        body {
            background-image: url('/images/background.png');
            background-image: image-set(
                url('/images/background.webp') type('image/webp'),
                url('/images/background.png') type('image/png')
            );
            background-repeat: repeat;
        }
    </style>
</head>

<body class="relative">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded focus:bg-white focus:px-4 focus:py-2 focus:text-black">
        {{ t('nav.skip', 'Skip to content') }}
    </a>
    <x-nav />
    <main id="main-content">
        {{ $slot }}
    </main>
    <x-footer />
</body>

</html>
