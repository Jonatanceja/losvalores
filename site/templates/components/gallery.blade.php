{{--
    Full-height image gallery slider. Data provided by App\View\Components\Gallery.
    $images — Kirby Files collection.
    Full viewport height, dragged with the mouse (GSAP Draggable, see
    resources/js/gallery.js). Navigation via small pill dots.
--}}
@if ($images->isNotEmpty())
    <section class="w-full">
        <div class="relative h-[50vh] w-full cursor-grab select-none overflow-hidden md:h-screen" data-gallery>

            {{-- Track: one full-screen slide per image, moved by GSAP. --}}
            <div class="flex h-full" data-gallery-track>
                @foreach ($images as $image)
                    {{-- overflow-hidden slide; the image is taller than the slide
                         so its parallax drift stays contained (no gaps). --}}
                    <figure class="relative h-full w-full shrink-0 overflow-hidden">
                        <x-picture
                            :file="$image"
                            sizes="100vw"
                            draggable="false"
                            data-parallax="70"
                            class="absolute inset-x-0 -top-[15%] h-[130%] w-full object-cover"
                        />
                    </figure>
                @endforeach
            </div>

            @if ($images->count() > 1)
                {{-- Dot indicators (active one stretches into a small pill). --}}
                <div class="absolute inset-x-0 bottom-6 flex justify-center gap-2" data-gallery-dots>
                    @foreach ($images as $image)
                        <button
                            type="button"
                            data-gallery-dot
                            aria-label="Go to image {{ $loop->iteration }}"
                            class="h-1.5 w-1.5 rounded-full bg-white/40 transition-all duration-300"
                        ></button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
