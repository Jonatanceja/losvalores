<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;
use Kirby\Cms\File;
use Kirby\Image\Focus;

class Picture extends Component
{
    public function __construct(
        public File $file,
        public string $sizes = '100vw',
    ) {}

    public function render(): View|Closure|string
    {
        // Focal point set in the Panel → CSS object-position (as "x% y%"), so
        // object-cover crops toward it instead of the center.
        $focus = null;
        if ($this->file->focus()->isNotEmpty()) {
            $focus = Focus::normalize($this->file->focus()->value());
        }

        return view('components.picture', ['focus' => $focus]);
    }
}
