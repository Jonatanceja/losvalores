<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class Intro extends Component
{
    protected Page $page;

    /**
     * Defaults to the current page, so templates only need <x-intro />.
     */
    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        return view('components.intro', [
            'title' => $this->page->introTitle(),
            'text'  => $this->page->introText(),
        ]);
    }
}
