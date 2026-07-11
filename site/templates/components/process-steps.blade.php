{{--
    Replicable "Process" steps. Data provided by App\View\Components\ProcessSteps.
    $steps — Kirby structure collection. Each step: image, title, intro,
    textLeft, textRight, footer. Layout mirrors the design:
    image → (title + intro) → two text columns → centered closing line.
--}}
@if ($steps->isNotEmpty())
    <section class="w-full">
        @foreach ($steps as $step)
            @php
                $image = $step->image()->toFile();
                // Intro text width (of the title row): literal classes so Tailwind sees them.
                $introWidth = match ($step->introWidth()->value()) {
                    '2/5' => 'md:w-2/5',
                    '4/5' => 'md:w-4/5',
                    default => 'md:w-3/5',
                };
            @endphp

            <div class="mx-auto max-w-8xl px-6 pt-16 pb-0 md:px-12 md:pt-24 md:pb-0">

                {{-- Image (contained parallax) --}}
                @if ($image)
                    <div class="relative aspect-[16/10] w-full overflow-hidden">
                        <x-picture
                            :file="$image"
                            sizes="(min-width: 1152px) 1152px, 100vw"
                            data-parallax="60"
                            class="absolute inset-x-0 -top-1/4 h-[150%] w-full object-cover"
                        />
                    </div>
                @endif

                {{-- Title + intro (flex; intro width is selectable: 2/5, 3/5, 4/5) --}}
                <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-baseline md:gap-8 items-top md:px-10" data-parallax="30">
                    @if ($step->title()->isNotEmpty())
                        <h2 class="font-toyprint text-3xl uppercase md:shrink-0 md:text-5xl">
                            {{ $step->title() }}
                        </h2>
                    @endif
                    @if ($step->intro()->isNotEmpty())
                        <div class="transform md:-translate-y-3 font-abhaya text-base md:text-lg {{ $introWidth }}">
                            {!! $step->intro()->kt() !!}
                        </div>
                    @endif
                </div>

                {{-- Two text columns --}}
                <div class="mt-6 grid grid-cols-1 gap-8 md:grid-cols-5 md:gap-16 md:px-10" data-parallax="45">
                    @if ($step->textLeft()->isNotEmpty())
                        <div class="font-elzevir text-xl leading-relaxed md:text-2xl col-span-2">
                            {!! $step->textLeft()->kt() !!}
                        </div>
                    @endif
                    @if ($step->textRight()->isNotEmpty())
                        <div class="font-elzevir text-xl leading-relaxed md:text-2xl col-span-2">
                            {!! $step->textRight()->kt() !!}
                        </div>
                    @endif
                </div>

                {{-- Closing line --}}
                @if ($step->footer()->isNotEmpty())
                    <p class="mt-6 text-center font-elzevir text-xl md:text-3xl md:px-10" data-parallax="55">
                        {{ $step->footer() }}
                    </p>
                @endif
            </div>
        @endforeach
    </section>
@endif
