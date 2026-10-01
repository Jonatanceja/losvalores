<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\Page;
use Kirby\Content\Field;

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

        // Bottles rotate in order: each visit (new session) starts at the
        // first one, then every reload/navigation advances to the next.
        $bottles = $page->bottles()->toStructure();
        $bottle = null;

        if ($bottles->isNotEmpty()) {
            $session = kirby()->session();
            $index = ($session->get('heroBottleIndex', -1) + 1) % $bottles->count();
            $session->set('heroBottleIndex', $index);
            $bottle = $bottles->slice($index, 1)->first();
        }

        return view('components.hero', [
            'logo'         => $page->logo()->toFile(),
            'bottle'       => $bottle?->image()->toFile(),
            'bottleName'   => $bottle?->name() ?? new Field($page, 'bottleName', ''),
            'heroText'     => $page->heroText(),
            'signature'    => $page->signature()->toFile(),
            'background'   => $page->background()->toFile(),
            'illustration' => $page->illustration()->toFile(),
        ]);
    }
}
