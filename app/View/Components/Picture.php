<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\File;

class Picture extends Component
{
    public function __construct(
        public File $file,
        public string $sizes = '100vw',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.picture');
    }
}
