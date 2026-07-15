{{--
    Responsive image. WebP is served through Kirby's thumbs `webp` srcset directly
    on the <img> (no <picture>/<source> content negotiation), with the original as
    the `src` fallback. Data provided by App\View\Components\Picture.
    $file  — Kirby File. $sizes — the `sizes` attribute (default 100vw).
    Extra attributes (class, alt, data-parallax, loading, …) pass through to <img>.
    SVGs are emitted as-is (no raster conversion).
--}}
@if ($file->extension() === 'svg')
    <img src="{{ $file->url() }}" {{ $attributes->merge(['alt' => $file->alt()->value()]) }}>
@else
    <img
        src="{{ $file->url() }}"
        srcset="{{ $file->srcset('webp') }}"
        sizes="{{ $sizes }}"
        @if ($focus) style="object-position: {{ $focus }}" @endif
        {{ $attributes->merge(['alt' => $file->alt()->value(), 'loading' => 'lazy']) }}
    >
@endif
