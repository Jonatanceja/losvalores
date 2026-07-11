{{--
    "Info" section for the place page. Data from App\View\Components\PlaceInfo.
    Portrait image / slider (left) + bulleted list (right).
    $images — Kirby Files collection: 1 image → static; 2+ → vertical (portrait)
    slider reusing the home gallery mechanism (resources/js/gallery.js).
    $items — textarea rendered as a markdown list via kirbytext.
--}}
@if ($images->isNotEmpty() || $items->isNotEmpty())
    <section class="w-full px-6 py-16 md:px-12 md:py-24">
        <div class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 md:grid-cols-2 md:gap-16">

            {{-- Image(s): portrait slider (2+) or static (1) --}}
            @if ($images->count() > 1)
                <div
                    class="relative aspect-[3/4] w-full cursor-grab select-none overflow-hidden"
                    data-gallery
                    data-parallax="50"
                >
                    <div class="flex h-full" data-gallery-track>
                        @foreach ($images as $image)
                            <figure class="h-full w-full shrink-0">
                                <x-picture
                                    :file="$image"
                                    sizes="(min-width: 768px) 50vw, 100vw"
                                    draggable="false"
                                    class="h-full w-full object-cover"
                                />
                            </figure>
                        @endforeach
                    </div>

                    <div class="absolute inset-x-0 bottom-4 flex justify-center gap-2" data-gallery-dots>
                        @foreach ($images as $image)
                            <button
                                type="button"
                                data-gallery-dot
                                aria-label="Go to image {{ $loop->iteration }}"
                                class="h-1.5 w-1.5 rounded-full bg-white/40 transition-all duration-300"
                            ></button>
                        @endforeach
                    </div>
                </div>
            @elseif ($images->count() === 1)
                <div class="relative aspect-[3/4] w-full overflow-hidden">
                    <x-picture
                        :file="$images->first()"
                        sizes="(min-width: 768px) 50vw, 100vw"
                        data-parallax="50"
                        class="absolute inset-x-0 -top-1/4 h-[150%] w-full object-cover"
                    />
                </div>
            @endif

            {{-- Bulleted list --}}
            @if ($items->isNotEmpty())
                <div
                    class="font-elzevir text-lg leading-relaxed md:text-xl [&_li]:pl-2 [&_ul]:list-disc [&_ul]:space-y-6 [&_ul]:pl-6"
                    data-parallax="40"
                >
                    {!! $items->kt() !!}
                </div>
            @endif
        </div>
    </section>
@endif
