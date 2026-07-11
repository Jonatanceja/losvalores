<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class Distillery extends Component
{
    protected Page $page;

    /**
     * Defaults to the current page, so templates only need <x-distillery />.
     */
    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        return view('components.distillery', [
            'title' => $this->page->distilleryTitle(),
            'text'  => $this->page->distilleryText(),
            'image' => $this->page->distilleryImage()->toFile(),
        ]);
    }
}
