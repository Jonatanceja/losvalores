{{--
    "Our Process" hero. Data provided by App\View\Components\ProcessHero.
    Full-screen background image with white text (text → title → subtitle) in
    the lower area. Each text element fades in on load AND parallaxes on scroll:
    the parallax lives on the wrapper, the fade on the inner element, so their
    y-transforms don't fight.
--}}
<section class="relative flex min-h-screen w-full items-end justify-center overflow-hidden pb-24 md:pb-32">

    {{-- Background image --}}
    @if ($image)
        <x-picture
            :file="$image"
            sizes="100vw"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 -z-20 h-full w-full object-cover"
        />
    @endif

    {{-- Gradient for text legibility over the image --}}
    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-black/60 via-black/10 to-transparent" aria-hidden="true"></div>

    {{-- Content --}}
    <div class="relative z-10 mx-auto max-w-2xl px-6 text-center text-white">

        @if ($text->isNotEmpty())
            <div data-parallax="40">
                <div data-fade class="font-abhaya text-lg leading-relaxed md:text-xl">
                    {!! $text->kt() !!}
                </div>
            </div>
        @endif

        @if ($title->isNotEmpty())
            <div data-parallax="70">
                <h1 data-fade class="font-toyprint text-4xl uppercase md:text-5xl">
                    {{ $title }}
                </h1>
            </div>
        @endif

        @if ($subtitle->isNotEmpty())
            <div data-parallax="95">
                <p data-fade class="font-elzevir text-2xl italic md:text-3xl md:ml-32">
                    {{ $subtitle }}
                </p>
            </div>
        @endif
    </div>
</section>
