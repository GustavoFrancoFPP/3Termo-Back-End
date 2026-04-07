<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament
    |--------------------------------------------------------------------------
    */

    'brand' => 'ConfecçãoTB',

    'colors' => [
        'primary' => \Filament\Support\Colors\Color::Slate,
        'danger' => \Filament\Support\Colors\Color::Rose,
        'gray' => \Filament\Support\Colors\Color::Slate,
        'info' => \Filament\Support\Colors\Color::Blue,
        'success' => \Filament\Support\Colors\Color::Emerald,
        'warning' => \Filament\Support\Colors\Color::Amber,
    ],

    'default_theme' => 'dark',

    'themes' => [
        'light',
        'dark',
    ],

    'cache' => [
        'is_enabled' => true,
    ],

    'sidebar' => [
        'is_collapsible_on_desktop' => false,
        'width' => '20rem',
    ],

    'favicon_url' => null,

];
