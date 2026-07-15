{{--
    A single tequila as an editorial block. Data from App\View\Components\TequilaProduct.

    Two layout variants (per-product `variant`):
    - standard: bottle over the presentation image on one side; name / subtitle /
      description + first gallery image on the other. Columns swap when $flip.
    - stacked: bottle on one side with the text UNDER it; the first gallery photo
      alone on the other side; the whole block pulls up to overlap the section above.
    The bottle carries the presentation image behind it (parallax) with the
    signature + stamp grouped over it. Remaining gallery images tile below.
--}}
@php
    $stacked = $variant === 'stacked';

    // With the stamp/signature beside the bottle we offset the bottle to one side
    // to make room; otherwise the bottle is centered over its backdrop.
    $marksBeside = $markPlacement === 'bottle';

    // Presentation backdrop placement. On mobile (marks beside) the backdrop is
    // pulled to one side with a set width so the stamp/signature fit on screen on
    // the other side; desktop keeps its current full-bleed behavior.
    $presentationPos = $marksBeside
        ? ($flip
            ? 'right-0 w-[85%] md:right-auto md:left-0 md:w-auto'
            : 'left-0 w-[85%] md:left-auto md:right-0 md:w-auto')
        : 'inset-x-0 mx-auto w-[90%]';

    // The first gallery image can sit beside the text; when it doesn't, every
    // gallery image drops to the grid below.
    $showColumnImage = $columnImage && $media->isNotEmpty();
    $rest = $columnImage ? $media->offset(1) : $media;

    $markTopClass = match ($markOffset) {
        'higher' => 'top-[-28%]',
        'lower' => 'top-[8%]',
        default => 'top-[-10%]',
    };

    $firstImageWidthClass = match ($firstImageWidth) {
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        'full' => 'max-w-none',
        default => 'max-w-md',
    };

    $galleryAspectClass = match ($galleryAspect) {
        '2/3' => 'aspect-[2/3]',
        '3/5' => 'aspect-[3/5]',
        '9/16' => 'aspect-[9/16]',
        default => 'aspect-[3/4]',
    };
@endphp

<article class="mx-auto w-full max-w-8xl px-6 py-16 md:px-12 md:py-24">

    <div class="mx-auto grid max-w-8xl grid-cols-1 items-start gap-10 md:grid-cols-2 md:gap-32">

        {{-- Bottle column (with the text under it when stacked) --}}
        <div class="{{ $flip ? 'md:order-2' : '' }}">

            {{-- Bottle over the presentation image, with stamp + signature.
                 When flipped the block mirrors: bottle right, stamp/signature left. --}}
            <div class="relative flex items-start {{ $marksBeside ? ($flip ? 'justify-end' : '') : 'justify-center' }}">

                @if ($presentation)
                    <div class="absolute top-0 overflow-hidden {{ $presentationPos }} {{ $presentationFormat === 'square' ? 'aspect-square' : 'aspect-[4/3]' }}">
                        <x-picture
                            :file="$presentation"
                            sizes="(min-width: 768px) 40vw, 90vw"
                            alt=""
                            aria-hidden="true"
                            class="h-full w-full object-cover"
                        />
                    </div>
                @endif

                @if ($bottle)
                    <x-picture
                        :file="$bottle"
                        sizes="(min-width: 768px) 30vw, 55vw"
                        data-parallax="70"
                        class="relative z-10 h-[48vh] w-auto object-contain md:h-[90vh] {{ $marksBeside ? ($flip ? '-mr-4 md:mr-[4%]' : '-ml-4 md:ml-[4%]') : '' }}"
                    />
                @endif

                @if ($markPlacement === 'bottle' && ($signature || $stamp))
                    <div class="absolute z-20 flex w-[52%] flex-col gap-1 md:w-[60%] {{ $markTopClass }} {{ $flip ? 'left-0 items-start md:-left-32' : 'right-0 items-end md:-right-32' }}" data-fade>
                        @if ($signature)
                            <x-picture :file="$signature" sizes="220px" class="w-full object-contain" />
                        @endif

                        @if ($stamp)
                            <x-picture :file="$stamp" sizes="260px" class="w-[85%] object-contain" />
                        @endif
                    </div>
                @endif
            </div>

            {{-- Stacked: name / subtitle / description under the bottle --}}
            @if ($stacked)
                <div class="-mt-4 md:-mt-12" data-parallax="30">
                    @include('components.tequila-text')
                </div>
            @endif
        </div>

        {{-- Right column. Standard: text then first image. Stacked: the first
             image alone, pulled up to overlap the section above. --}}
        <div class="flex flex-col {{ $stacked ? 'justify-start' : 'justify-end' }} {{ $flip ? 'items-start md:order-1' : 'items-end' }}">

            @unless ($stacked)
                <div data-parallax="30">
                    @include('components.tequila-text')
                </div>
            @endunless

            @if ($showColumnImage)
                <div class="relative w-full overflow-hidden {{ $galleryAspectClass }} {{ $firstImageWidthClass }} {{ $stacked ? 'md:-mt-64' : 'mt-10' }}">
                    <x-picture
                        :file="$media->first()"
                        sizes="(min-width: 768px) 40vw, 100vw"
                        data-parallax="35"
                        class="absolute inset-x-0 -top-[15%] h-[130%] w-full object-cover"
                    />
                </div>
            @endif
        </div>
    </div>

    {{-- Remaining gallery images (from the second on). Stacked variant shows them
         wide and centered at ~3/4 width; standard tiles them two-up, portrait. --}}
    @if ($rest->isNotEmpty())
        <div class="mt-12 md:mt-20 {{ $stacked ? 'flex flex-col items-start gap-8' : 'grid grid-cols-1 gap-0 md:grid-cols-2' }}">
            @foreach ($rest as $image)
                <div class="relative w-full overflow-hidden {{ $stacked ? 'aspect-[3/2] md:w-3/4' : $galleryAspectClass }}">
                    <x-picture
                        :file="$image"
                        sizes="{{ $stacked ? '(min-width: 768px) 75vw, 100vw' : '(min-width: 768px) 50vw, 100vw' }}"
                        data-parallax="{{ $loop->even ? 55 : 35 }}"
                        class="absolute inset-x-0 -top-[15%] h-[130%] w-full object-cover"
                    />
                </div>
            @endforeach
        </div>
    @endif
</article>
