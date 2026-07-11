<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;

class TequilaList extends Component
{
    protected Page $page;

    public function __construct(?Page $page = null)
    {
        $this->page = $page ?? page();
    }

    public function render(): View|Closure|string
    {
        return view('components.tequila-list', [
            'products' => $this->page->children()->listed(),
        ]);
    }
}
