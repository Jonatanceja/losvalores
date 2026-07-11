{{--
    Closing subtitle band. Data provided by App\View\Components\ProcessClosing.
    A single centered line (Elzevir) over the site-wide paper texture.
--}}
@if ($subtitle->isNotEmpty())
    <section class="w-full px-6 py-20 md:py-28">
        <p class="mx-auto max-w-4xl text-center font-elzevir text-2xl md:text-4xl" data-parallax="40">
            {{ $subtitle }}
        </p>
    </section>
@endif
