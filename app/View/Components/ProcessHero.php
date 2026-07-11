<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class ProcessHero extends Component
{
    protected Page $page;

    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        return view('components.process-hero', [
            'image'    => $this->page->heroImage()->toFile(),
            'title'    => $this->page->heroTitle(),
            'subtitle' => $this->page->heroSubtitle(),
            'text'     => $this->page->heroText(),
        ]);
    }
}
