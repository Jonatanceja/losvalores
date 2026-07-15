<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class TequilaProduct extends Component
{
    protected Page $page;

    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        return view('components.tequila-product', [
            'flip' => $this->page->flip()->toBool(),
            'variant' => $this->page->variant()->or('standard')->value(),
            'presentationFormat' => $this->page->presentationFormat()->or('landscape')->value(),
            'firstImageWidth' => $this->page->firstImageWidth()->or('md')->value(),
            'galleryAspect' => $this->page->galleryAspect()->or('3/4')->value(),
            'markOffset' => $this->page->markOffset()->or('default')->value(),
            'markPlacement' => $this->page->markPlacement()->or('bottle')->value(),
            'columnImage' => $this->page->columnImage()->isEmpty() ? true : $this->page->columnImage()->toBool(),
            'bottle' => $this->page->bottleImage()->toFile(),
            'presentation' => $this->page->presentationImage()->toFile(),
            'signature' => $this->page->signature()->toFile(),
            'stamp' => $this->page->stamp()->toFile(),
            'media' => $this->page->gallery()->toFiles(),
            'title' => $this->page->title(),
            'subtitle' => $this->page->subtitle(),
            'description' => $this->page->description(),
        ]);
    }
}
