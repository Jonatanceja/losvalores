{{--
    Site footer. Data provided by App\View\Components\Footer.
    Dark section with the main logo (rendered white via `brightness-0 invert`),
    the published pages, disclaimer, contact and social links, and the emblem.
--}}
<footer class="w-full bg-black text-white">
    <div class="mx-auto max-w-4xl px-6 py-16 text-center md:py-20">

        {{-- Logo, converted to white --}}
        <a href="{{ site()->url() }}" class="mx-auto block max-w-2xl">
            <img
                src="{{ $logo?->url() ?? url('images/los-valores-logo.svg') }}"
                alt="{{ site()->title() }}"
                class="w-full brightness-0 invert"
            />
        </a>

        {{-- Published pages --}}
        @if ($pages->isNotEmpty())
            <nav class="mt-10">
                <ul class="flex flex-wrap justify-center gap-x-8 gap-y-2 font-abhaya text-lg">
                    @foreach ($pages as $item)
                        <li>
                            <a href="{{ $item->url() }}" class="transition-opacity hover:opacity-60">
                                {{ $item->title() }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        {{-- Disclaimer --}}
        @if ($disclaimer->isNotEmpty())
            <p class="mt-8 font-abhaya text-base text-white/80">
                {{ $disclaimer }}
            </p>
        @endif

        {{-- Contact --}}
        @if ($email->isNotEmpty() || $phone->isNotEmpty())
            <p class="mt-4 font-abhaya text-sm text-white/70">
                @if ($email->isNotEmpty())
                    <a href="mailto:{{ $email }}" class="hover:opacity-60">{{ $email }}</a>
                @endif
                @if ($email->isNotEmpty() && $phone->isNotEmpty())
                    <span class="mx-2">·</span>
                @endif
                @if ($phone->isNotEmpty())
                    <a href="tel:{{ $phone }}" class="hover:opacity-60">{{ $phone }}</a>
                @endif
            </p>
        @endif

        {{-- Social --}}
        @php $socialLinks = array_filter($social, fn ($field) => $field->isNotEmpty()); @endphp
        @if (count($socialLinks))
            <ul class="mt-4 flex justify-center gap-x-6 font-abhaya text-sm">
                @foreach ($socialLinks as $name => $url)
                    <li>
                        <a href="{{ $url }}" target="_blank" rel="noopener" class="text-white/80 hover:opacity-60">
                            {{ $name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Emblem (site favicon) --}}
        @if ($favicon)
            <img
                src="{{ $favicon->url() }}"
                alt=""
                aria-hidden="true"
                class="mx-auto mt-10 h-10 w-auto"
            />
        @endif
    </div>
</footer>
