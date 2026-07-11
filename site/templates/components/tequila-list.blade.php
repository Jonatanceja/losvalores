{{--
    "Our Tequilas" page. Data from App\View\Components\TequilaList.
    Renders every product child with the tequila-product component, alternating
    the layout side on each one.
--}}
@if ($products->isNotEmpty())
    <div class="w-full pt-24 md:pt-32">
        @foreach ($products as $product)
            <x-tequila-product :page="$product" />
        @endforeach
    </div>
@endif
