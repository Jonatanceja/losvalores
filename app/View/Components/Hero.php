<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class Hero extends Component
{
    protected Page $page;

    /**
     * Defaults to the current page, so templates only need <x-hero />.
     */
    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        $page = $this->page;

        return view('components.hero', [
            'logo'         => $page->logo()->toFile(),
            'bottle'       => $page->bottle()->toFile(),
            'bottleName'   => $page->bottleName(),
            'heroText'     => $page->heroText(),
            'signature'    => $page->signature()->toFile(),
            'background'   => $page->background()->toFile(),
            'illustration' => $page->illustration()->toFile(),
        ]);
    }
}
