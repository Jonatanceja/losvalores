{{--
    "Meet the place" section. Data provided by App\View\Components\Place.
    Full-bleed, two columns with no gap. Padding lives only on the text blocks;
    the images run flush to the edges and to each other. The second column is
    offset downward to match the staggered design.
    Transparent background so the site-wide paper texture shows through.
--}}
<section class="w-full">
    <div class="grid grid-cols-1 md:grid-cols-2">

        {{-- Column one --}}
        <div class="flex flex-col">
            <div class="relative z-10 flex flex-col gap-6 p-8 md:p-32">
                @if ($textOne->isNotEmpty())
                    <div class="font-abhaya text-base leading-relaxed md:text-lg" data-parallax="40">
                        {!! $textOne->kt() !!}
                    </div>
                @endif

                @if ($titleOne->isNotEmpty())
                    <h2 class="font-toyprint text-3xl uppercase leading-tight md:text-5xl" data-parallax="90">
                        {{ $titleOne }}
                    </h2>
                @endif
            </div>

            @if ($imageOne)
                {{-- overflow-hidden frame; the image is taller than the frame so
                     the parallax drift stays contained (no gaps). --}}
                <div class="relative aspect-[3/4] w-full overflow-hidden">
                    <x-picture
                        :file="$imageOne"
                        sizes="(min-width: 768px) 50vw, 100vw"
                        data-parallax="60"
                        class="absolute inset-x-0 -top-1/4 h-[150%] w-full object-cover"
                    />
                </div>
            @endif
        </div>

        {{-- Column two — offset down --}}
        <div class="flex flex-col md:mt-40">
            <div class="relative z-10 flex flex-col gap-6 p-8 md:p-32">
                @if ($textTwo->isNotEmpty())
                    <div class="font-abhaya text-base leading-relaxed md:text-lg" data-parallax="70">
                        {!! $textTwo->kt() !!}
                    </div>
                @endif

                @if ($titleTwo->isNotEmpty())
                    <h2 class="font-toyprint text-3xl uppercase leading-tight md:text-5xl" data-parallax="120">
                        {{ $titleTwo }}
                    </h2>
                @endif
            </div>

            @if ($imageTwo)
                {{-- overflow-hidden frame; the image is taller than the frame so
                     the parallax drift stays contained (no gaps). --}}
                <div class="relative aspect-[3/4] w-full overflow-hidden">
                    <x-picture
                        :file="$imageTwo"
                        sizes="(min-width: 768px) 50vw, 100vw"
                        data-parallax="110"
                        class="absolute inset-x-0 -top-1/4 h-[150%] w-full object-cover"
                    />
                </div>
            @endif
        </div>
    </div>
</section>
