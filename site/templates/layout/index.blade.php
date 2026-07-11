<!doctype html>
<html lang="{{ kirby()->language()?->code() ?? 'en' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="@csrf()">

    <title>{{ page()->title() }} | {{ site()->title() }}</title>

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
    <x-nav />
    {{ $slot }}
    <x-footer />
</body>

</html>
