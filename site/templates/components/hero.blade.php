{{--
    Hero section for the home page.
    Data is provided by App\View\Components\Hero — this file is markup only.
    Fields: $logo, $bottle, $signature, $background, $illustration (File|null)
            $bottleName, $heroText (Kirby field)
--}}
<section class="relative flex min-h-screen w-full flex-col overflow-hidden">

    {{-- Background layer. Its own layer so the overlay blend only affects the
         background (fusing it with the site's paper texture behind), not the
         content. The dynamic media URL is the only unavoidable inline style. --}}
    @if ($background)
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat mix-blend-overlay opacity-50 transform rotate-180"
            style="background-image: url('{{ $background->url() }}');"
            aria-hidden="true"
        ></div>
    @endif

    {{-- Illustration backdrop, pinned flush to the bottom edge.
         data-illustration: used as the target the parallax bottle travels to. --}}
    @if ($illustration)
        <x-picture
            :file="$illustration"
            sizes="100vw"
            alt=""
            aria-hidden="true"
            data-illustration
            class="pointer-events-none absolute inset-x-0 bottom-0 block w-full opacity-70"
        />
    @endif

    {{-- Foreground content --}}
    <div class="relative z-10 mx-auto flex w-full max-w-6xl flex-1 flex-col px-6">

        {{-- Logo / brand mark. Extra top padding leaves room for the nav. --}}
        @if ($logo)
            <div class="flex justify-center pt-44 md:pt-52" data-fade>
                <x-picture
                    :file="$logo"
                    sizes="(min-width: 768px) 64rem, 90vw"
                    alt="{{ $logo->alt()->or(site()->title()) }}"
                    class="w-full max-w-5xl"
                />
            </div>
        @endif

        {{-- bottle name | bottle | hero text + signature --}}
        <div class="grid flex-1 grid-cols-1 items-center gap-4 pt-10 pb-32 md:grid-cols-3 md:pb-48">

            {{-- Left: bottle name --}}
            <div class="relative z-30 order-2 text-center md:order-1 md:text-right" data-fade>
                @if ($bottleName->isNotEmpty())
                    <p class="font-abhaya text-xl md:text-4xl uppercase leading-tight tracking-wide">
                        {{ site()->title() }}
                    </p>
                    <p class="font-abhaya text-xl md:text-4xl uppercase leading-tight tracking-wide">
                        {{ $bottleName }}
                    </p>
                @endif
            </div>

            {{-- Center: bottle. Pulled up with a negative margin and raised
                 above the logo so it overlaps the brand mark. --}}
            <div class="order-1 flex justify-center md:order-2">
                @if ($bottle)
                    <x-picture
                        :file="$bottle"
                        sizes="(min-width: 768px) 40vw, 80vw"
                        alt="{{ $bottle->alt()->or($bottleName) }}"
                        data-parallax-bottle
                        class="relative z-20 -mt-32 h-auto w-[85vw] max-w-none md:h-[145vh] md:w-auto md:-mt-64"
                    />
                @endif
            </div>

            {{-- Right: hero text + signature --}}
            <div class="relative z-30 order-3 space-y-6 text-center md:text-left" data-fade>
                @if ($heroText->isNotEmpty())
                    <div class="font-abhaya text-xl md:text-3xl font-medium uppercase leading-tight">
                        {!! $heroText->kt() !!}
                    </div>
                @endif

                @if ($signature)
                    <x-picture
                        :file="$signature"
                        sizes="24rem"
                        alt="{{ $signature->alt()->or('') }}"
                        class="mx-auto w-96 md:mx-0"
                    />
                @endif
            </div>
        </div>
    </div>
</section>
