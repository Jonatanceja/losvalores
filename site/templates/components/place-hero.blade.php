{{--
    "Place" hero. Data provided by App\View\Components\PlaceHero.
    The whole section is padded so the background image sits inside a paper
    frame (the site texture shows in the margin). Title (left) + text (right)
    sit over the image, below the nav. Each fades in on load, then parallaxes
    on scroll (parallax on the wrapper, fade on the inner element).
--}}
<section class="flex min-h-screen w-full p-4 md:p-6">
    <div class="relative w-full flex-1 overflow-hidden">

        {{-- Background image (inset within the padded section) --}}
        @if ($image)
            <x-picture
                :file="$image"
                sizes="100vw"
                alt=""
                aria-hidden="true"
                class="absolute inset-0 -z-10 h-full w-full object-cover"
            />
        @endif

        {{-- Title (left) + text (right), below the nav --}}
        <div class="relative z-10 mx-auto max-w-6xl px-6 pt-36 md:px-12 md:pt-48">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-16">

                @if ($title->isNotEmpty())
                    <div data-parallax="40">
                        <h1 data-fade class="font-elzevir text-3xl leading-tight md:text-5xl">
                            {{ $title }}
                        </h1>
                    </div>
                @endif

                @if ($text->isNotEmpty())
                    <div data-parallax="60">
                        <div data-fade class="font-abhaya text-sm leading-relaxed md:text-base">
                            {!! $text->kt() !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
