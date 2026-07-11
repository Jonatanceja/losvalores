<?php

return [
    // ImageMagick driver, full path so the web server (Herd/PHP-FPM) resolves
    // the binary regardless of its PATH.
    'driver' => 'im',
    'bin' => '/opt/homebrew/bin/magick',
    'quality' => 80,

    'srcsets' => [
        'webp' => [
            '320w' => ['width' => 320, 'format' => 'webp'],
            '640w' => ['width' => 640, 'format' => 'webp'],
            '768w' => ['width' => 768, 'format' => 'webp'],
            '1024w' => ['width' => 1024, 'format' => 'webp'],
            '1280w' => ['width' => 1280, 'format' => 'webp'],
            '1536w' => ['width' => 1536, 'format' => 'webp'],
            '1920w' => ['width' => 1920, 'format' => 'webp'],
        ],
    ],
];
