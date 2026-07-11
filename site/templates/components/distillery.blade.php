{{--
    "Distillery" section. Data provided by App\View\Components\Distillery.
    $title, $text — Kirby fields. $image — File|null.
    Inset image on top; below it the title (left) and text (right).
    Transparent background so the site-wide paper texture frames the image.
--}}
<section class="w-full px-6 py-16 md:px-12 md:py-24">
    <div class="mx-auto max-w-8xl">

        {{-- Image in an overflow-hidden frame so the parallax drift stays
             contained (the image is taller than the frame). --}}
        @if ($image)
            <div class="relative aspect-4/2 w-full overflow-hidden">
                <x-picture
                    :file="$image"
                    sizes="100vw"
                    data-parallax="70"
                    class="absolute inset-x-0 -top-1/4 h-[150%] w-full object-cover"
                />
            </div>
        @endif

        {{-- Title (left) + text (right) --}}
        <div class="relative z-10 mt-12 grid grid-cols-1 gap-8 md:grid-cols-5 md:gap-16">
            @if ($title->isNotEmpty())
                <h2 class="font-toyprint text-3xl uppercase leading-tight md:text-5xl col-span-2" data-parallax="30">
                    {{ $title }}
                </h2>
            @endif

            @if ($text->isNotEmpty())
                <div class="font-abhaya text-base leading-relaxed md:text-lg col-span-2" data-parallax="55">
                    {!! $text->kt() !!}
                </div>
            @endif
        </div>
    </div>
</section>
