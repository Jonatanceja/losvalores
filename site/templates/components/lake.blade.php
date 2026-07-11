{{--
    "The lake" section. Data provided by App\View\Components\Lake.
    $title, $text — Kirby fields. $illustration — File|null.
    Full-width illustration with the title overlaid top-left and the text
    top-right (over the engraving's sky), matching the design.
--}}
<section class="relative w-full">

    {{-- Illustration --}}
    @if ($illustration)
        <x-picture
            :file="$illustration"
            sizes="100vw"
            class="w-full object-cover"
        />
    @endif

    {{-- Title (top-left) + text (top-right), overlaid on the sky area --}}
    <div class="absolute inset-x-0 top-0 z-10 px-6 pb-8 pt-20 md:px-12 md:pb-10 md:pt-32">
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
