{{--
    "The lake" section. Data provided by App\View\Components\Lake.
    $title, $text — Kirby fields. $illustration — File|null.
    Full-width illustration with the title overlaid top-left and the text
    top-right (over the engraving's sky), matching the design.
--}}
<section class="relative flex w-full flex-col md:block">

    {{-- Illustration (mobile: below the text; md+: the text overlays it) --}}
    @if ($illustration)
        <x-picture
            :file="$illustration"
            sizes="100vw"
            class="order-2 w-full object-cover md:order-none"
        />
    @endif

    {{-- Title (top-left) + text (top-right), overlaid on the sky area --}}
    <div class="relative z-10 order-1 px-6 pb-0 pt-16 md:absolute md:inset-x-0 md:top-0 md:px-12 md:pb-10 md:pt-32">
        <div class="mx-auto flex max-w-6xl flex-col gap-8 sm:flex-row sm:items-start sm:justify-between">

            @if ($title->isNotEmpty())
                <h2 class="max-w-xs font-toyprint text-3xl uppercase leading-tight md:text-5xl" data-parallax="25">
                    {{ $title }}
                </h2>
            @endif

            @if ($subtitle->isNotEmpty() || $text->isNotEmpty())
                <div class="max-w-sm" data-parallax="45">
                    @if ($subtitle->isNotEmpty())
                        <p class="mb-3 font-elzevir text-lg italic md:text-xl">
                            {{ $subtitle }}
                        </p>
                    @endif

                    @if ($text->isNotEmpty())
                        <div class="font-abhaya text-sm leading-relaxed md:text-base">
                            {!! $text->kt() !!}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>
