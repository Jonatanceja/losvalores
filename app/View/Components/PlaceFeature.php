<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class PlaceFeature extends Component
{
    protected Page $page;

    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        return view('components.place-feature', [
            'image' => $this->page->featureImage()->toFile(),
            'title' => $this->page->featureTitle(),
            'text'  => $this->page->featureText(),
        ]);
    }
}
