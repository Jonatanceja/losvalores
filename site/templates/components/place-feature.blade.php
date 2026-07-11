{{--
    "Feature" section for the place page. Data from App\View\Components\PlaceFeature.
    A wide engraving-style image with the title centered over its top, and a
    caption/text below. Padded so the site paper texture frames the block.
    Title + text fade in, then parallax on scroll.
--}}
@if ($image || $title->isNotEmpty() || $text->isNotEmpty())
    <section class="w-full px-4 py-16 md:px-6 md:py-24">
        <div class="mx-auto max-w-8xl">

            {{-- Image with the title overlaid across its top --}}
            @if ($image)
                <figure class="relative w-full overflow-hidden">
                    <x-picture
                        :file="$image"
                        sizes="(min-width: 1152px) 72rem, 100vw"
                        alt=""
                        aria-hidden="true"
                        class="h-full w-full object-cover invert"
                    />

                    @if ($title->isNotEmpty())
                        <figcaption class="absolute inset-x-0 top-0 px-6 pt-8 text-center md:pt-12" data-parallax="30">
                            <h2 data-fade class="font-elzevir text-2xl text-white italic md:text-4xl">
                                {{ $title }}
                            </h2>
                        </figcaption>
                    @endif
                </figure>
            @elseif ($title->isNotEmpty())
                <h2 data-fade class="text-center font-elzevir text-2xl italic md:text-4xl">
                    {{ $title }}
                </h2>
            @endif

            {{-- Caption / text below the image --}}
            @if ($text->isNotEmpty())
                <div data-parallax="40">
                    <div data-fade class="mt-3 font-abhaya text-base leading-relaxed md:mt-4 md:text-lg max-w-6xl md:px-10">
                        {!! $text->kt() !!}
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif
