<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Footer extends Component
{
    public function render(): View|Closure|string
    {
        $site = site();

        return view('components.footer', [
            'logo'       => $site->logo()->toFile(),
            'favicon'    => $site->favicon()->toFile(),
            'pages'      => $site->children()->listed(),
            'disclaimer' => $site->disclaimer(),
            'email'      => $site->email(),
            'phone'      => $site->phone(),
            'social'     => [
                'Instagram' => $site->instagram(),
                'Facebook'  => $site->facebook(),
                'TikTok'    => $site->tiktok(),
                'X'         => $site->x(),
            ],
        ]);
    }
}
