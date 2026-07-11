<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Nav extends Component
{
    public function render(): View|Closure|string
    {
        $page = page();

        // One entry per language, each linking to the current page's translation.
        $languages = [];
        foreach (kirby()->languages() as $language) {
            $languages[] = [
                'label' => strtoupper($language->code()),
                'url' => $page ? $page->url($language->code()) : site()->url($language->code()),
                'active' => kirby()->language()?->code() === $language->code(),
            ];
        }

        return view('components.nav', [
            // Published (listed) top-level pages.
            'pages' => site()->children()->listed(),
            // White variant for pages with a dark hero (per-page `darkNav` flag).
            'dark' => $page ? $page->darkNav()->toBool() : false,
            // On home the logo is hidden but keeps its space (the hero has its own).
            'home' => $page ? $page->isHomePage() : false,
            // Language switcher (only shown when the site is multi-language).
            'languages' => $languages,
        ]);
    }
}
