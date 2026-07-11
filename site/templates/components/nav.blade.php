{{--
    Top navigation. Data is provided by App\View\Components\Nav.
    $pages — published (listed) top-level pages (Kirby Pages collection).
    $dark  — true on dark-hero pages: white logo + white links.

    Desktop: the centered top nav plus a black sticky bar that drops in on scroll.
    Mobile: a hamburger (in both bars) opens the full-screen slide-in menu below.
--}}
<nav data-nav-top @class(['absolute inset-x-0 top-0 z-30 w-full', 'text-white' => $dark])>
    <div class="mx-auto flex max-w-6xl items-center justify-between px-6 pt-10 md:flex-col md:justify-center">

        {{-- Brand logo. On mobile it sits on the left; on desktop it is centered
             above the nav. On dark pages the black SVG is inverted to white.
             On home it is hidden but keeps its space (the hero shows the logo). --}}
        <a href="{{ site()->url() }}" @class(['block md:mb-8', 'invisible' => $home]) data-fade>
            <img
                src="{{ url('images/los-valores-logo.svg') }}"
                alt="{{ site()->title() }}"
                @class(['h-10 w-auto md:h-16', 'brightness-0 invert' => $dark])
            />
        </a>

        {{-- Hamburger (mobile only) --}}
        <button type="button" data-menu-open aria-label="Open menu" class="shrink-0 md:hidden">
            <svg width="42" height="42" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
                <line x1="4" y1="10" x2="26" y2="10" />
                <line x1="9" y1="15" x2="26" y2="15" />
                <line x1="14" y1="20" x2="26" y2="20" />
            </svg>
        </button>

        {{-- Links + inline language switcher (desktop only) --}}
        <ul class="hidden flex-wrap items-center justify-center gap-x-8 gap-y-2 font-elzevir md:flex" data-fade>
            @foreach ($pages as $item)
                <li>
                    <a
                        href="{{ $item->url() }}"
                        @class([
                            'text-lg tracking-wide transition-opacity hover:opacity-60',
                            'font-bold' => $item->isOpen(),
                        ])
                        @if ($item->isOpen()) aria-current="page" @endif
                    >
                        {{ $item->title() }}
                    </a>
                </li>
            @endforeach

            @if (count($languages) > 1)
                <li class="flex items-center gap-2 text-sm tracking-widest">
                    @foreach ($languages as $i => $language)
                        @if ($i > 0)
                            <span aria-hidden="true" class="opacity-40">/</span>
                        @endif
                        <a
                            href="{{ $language['url'] }}"
                            @class([
                                'transition-opacity hover:opacity-60',
                                'font-bold' => $language['active'],
                                'opacity-50' => ! $language['active'],
                            ])
                            @if ($language['active']) aria-current="true" @endif
                        >
                            {{ $language['label'] }}
                        </a>
                    @endforeach
                </li>
            @endif
        </ul>
    </div>
</nav>

{{--
    Sticky bar. Hidden (translated up) until the top nav scrolls out of view, then
    it slides down. Black with white text. Desktop: logo / navigation / languages.
    Mobile: logo + hamburger. Toggled by resources/js/nav.js.
--}}
<div
    data-nav-sticky
    class="fixed inset-x-0 top-0 z-40 -translate-y-full border-b border-white/10 bg-black/95 text-white backdrop-blur transition-transform duration-300 ease-out"
>
    <div class="mx-auto flex max-w-8xl items-center gap-8 px-6 py-5 md:px-12">

        {{-- Logo (left) --}}
        <a href="{{ site()->url() }}" class="shrink-0">
            <img src="{{ url('images/los-valores-logo.svg') }}" alt="{{ site()->title() }}" class="h-9 w-auto brightness-0 invert md:h-10" />
        </a>

        {{-- Navigation (center, grows to fill) — desktop only --}}
        <ul class="hidden flex-1 items-center justify-center gap-x-8 font-elzevir md:flex">
            @foreach ($pages as $item)
                <li>
                    <a
                        href="{{ $item->url() }}"
                        @class(['tracking-wide transition-opacity hover:opacity-60', 'font-bold' => $item->isOpen()])
                        @if ($item->isOpen()) aria-current="page" @endif
                    >
                        {{ $item->title() }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Languages (right) — desktop only --}}
        @if (count($languages) > 1)
            <div class="hidden shrink-0 items-center gap-2 font-elzevir text-sm tracking-widest md:flex">
                @foreach ($languages as $i => $language)
                    @if ($i > 0)
                        <span aria-hidden="true" class="opacity-40">/</span>
                    @endif
                    <a
                        href="{{ $language['url'] }}"
                        @class([
                            'transition-opacity hover:opacity-60',
                            'font-bold' => $language['active'],
                            'opacity-50' => ! $language['active'],
                        ])
                        @if ($language['active']) aria-current="true" @endif
                    >
                        {{ $language['label'] }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Hamburger (mobile only) --}}
        <button type="button" data-menu-open aria-label="Open menu" class="ml-auto shrink-0 md:hidden">
            <svg width="38" height="38" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
                <line x1="4" y1="10" x2="26" y2="10" />
                <line x1="9" y1="15" x2="26" y2="15" />
                <line x1="14" y1="20" x2="26" y2="20" />
            </svg>
        </button>
    </div>
</div>

{{--
    Mobile menu: full-screen slide-in from the right, black with white text.
    Links centered, language switcher pinned at the bottom. Toggled by nav.js.
--}}
<div
    data-menu
    class="fixed inset-0 z-50 translate-x-full bg-black text-white transition-transform duration-300 ease-out md:hidden"
>
    <div class="flex h-full flex-col px-8 py-10">

        {{-- Close --}}
        <button type="button" data-menu-close aria-label="Close menu" class="-mr-2 self-end p-2">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round" />
            </svg>
        </button>

        {{-- Links (left-aligned, grows) --}}
        <ul class="flex flex-1 flex-col items-start justify-center gap-8 font-elzevir">
            @foreach ($pages as $item)
                <li>
                    <a
                        href="{{ $item->url() }}"
                        @class(['text-2xl tracking-wide', 'font-bold' => $item->isOpen()])
                        @if ($item->isOpen()) aria-current="page" @endif
                    >
                        {{ $item->title() }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Languages (bottom) --}}
        @if (count($languages) > 1)
            <div class="flex items-center justify-center gap-3 font-elzevir text-base tracking-widest">
                @foreach ($languages as $i => $language)
                    @if ($i > 0)
                        <span aria-hidden="true" class="opacity-40">/</span>
                    @endif
                    <a
                        href="{{ $language['url'] }}"
                        @class(['font-bold' => $language['active'], 'opacity-50' => ! $language['active']])
                        @if ($language['active']) aria-current="true" @endif
                    >
                        {{ $language['label'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
