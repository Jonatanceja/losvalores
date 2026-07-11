{{--
    Intro section. Data is provided by App\View\Components\Intro.
    $title, $text — Kirby fields.
    No background: the section is transparent so the site-wide paper texture
    (on <body>) shows through.
--}}
<section class="w-full px-6 py-24 md:py-32">
    <div class="mx-auto max-w-lg">

        @if ($text->isNotEmpty())
            <div class="font-abhaya text-base leading-relaxed md:text-lg sm:ml-20" data-parallax="40">
                {!! $text->kt() !!}
            </div>
        @endif

        @if ($title->isNotEmpty())
            <h2 class="mt-5 font-toyprint text-3xl uppercase md:text-5xl text-center" data-parallax="90">
                {{ $title }}
            </h2>
        @endif
    </div>
</section>
