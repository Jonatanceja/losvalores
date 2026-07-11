{{--
    Responsive <picture> that serves AVIF and WebP (via Kirby thumbs srcsets),
    with the original as the fallback. Data provided by App\View\Components\Picture.
    $file  — Kirby File. $sizes — the `sizes` attribute (default 100vw).
    Extra attributes (class, alt, data-parallax, loading, …) pass through to <img>.
    SVGs are emitted as-is (no raster conversion).
--}}
@if ($file->extension() === 'svg')
    <img src="{{ $file->url() }}" {{ $attributes->merge(['alt' => $file->alt()->value()]) }}>
@else
    {{-- display:contents so the wrapper doesn't affect layout; the <img> lays
         out exactly as it would on its own (positioning, aspect, object-fit). --}}
    <picture class="contents">
        <source type="image/avif" srcset="{{ $file->srcset('avif') }}" sizes="{{ $sizes }}">
        <source type="image/webp" srcset="{{ $file->srcset('webp') }}" sizes="{{ $sizes }}">
        <img
            src="{{ $file->url() }}"
            {{ $attributes->merge(['alt' => $file->alt()->value(), 'loading' => 'lazy']) }}
        >
    </picture>
@endif
