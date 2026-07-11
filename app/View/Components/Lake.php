<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class Lake extends Component
{
    protected Page $page;

    /**
     * Defaults to the current page, so templates only need <x-lake />.
     */
    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        return view('components.lake', [
            'title'        => $this->page->lakeTitle(),
            'subtitle'     => $this->page->lakeSubtitle(),
            'text'         => $this->page->lakeText(),
            'illustration' => $this->page->lakeIllustration()->toFile(),
        ]);
    }
}
