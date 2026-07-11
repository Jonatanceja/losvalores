<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class Place extends Component
{
    protected Page $page;

    /**
     * Defaults to the current page, so templates only need <x-place />.
     */
    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        $page = $this->page;

        return view('components.place', [
            'textOne'  => $page->placeTextOne(),
            'titleOne' => $page->placeTitleOne(),
            'imageOne' => $page->placeImageOne()->toFile(),
            'textTwo'  => $page->placeTextTwo(),
            'titleTwo' => $page->placeTitleTwo(),
            'imageTwo' => $page->placeImageTwo()->toFile(),
        ]);
    }
}
