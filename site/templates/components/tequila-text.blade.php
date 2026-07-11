{{-- Name / subtitle / description block, shared by the tequila-product layouts.
     When markPlacement is "text" the stamp (top) + signature sit above the name. --}}
@if ($markPlacement === 'text' && ($signature || $stamp))
    <div class="mb-8 flex w-56 flex-col gap-2 md:w-[22rem] {{ $flip ? 'items-start md:ml-[18rem]' : 'items-end md:mr-[18rem]' }}">
        @if ($signature)
            <x-picture :file="$signature" sizes="280px" class="w-full object-contain" />
        @endif

        @if ($stamp)
            <x-picture :file="$stamp" sizes="280px" class="w-full object-contain" />
        @endif
    </div>
@endif

@if ($title->isNotEmpty())
    <h2 data-fade class="font-toyprint text-3xl tracking-wide uppercase md:text-5xl {{ $markPlacement === 'text' ? 'max-w-sm' : '' }}">{{ $title }}</h2>
@endif

@if ($subtitle->isNotEmpty())
    <p data-fade class="mt-1 font-elzevir text-2xl italic md:text-4xl {{ $markPlacement === 'text' ? 'max-w-sm' : '' }}">{{ $subtitle }}</p>
@endif

@if ($description->isNotEmpty())
    <div data-fade class="mt-6 font-abhaya text-base leading-relaxed md:text-lg {{ $markPlacement === 'text' ? 'max-w-sm' : 'max-w-md' }}">
        {!! $description->kt() !!}
    </div>
@endif
