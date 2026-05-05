<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewMon extends Model
{
    protected $table = 'new_mons';
    
    protected $fillable = [
        'name',
        'pokemon_id',
        'image_path',
        'type',
        'height',
        'weight',
        'abilities',
        'stats',
        'sprite_official',
        'sprite_front',
        'sprite_back',
        'sprite_front_shiny',
        'sprite_back_shiny',
    ];

    protected $casts = [
        'abilities' => 'array',
        'stats' => 'array',
    ];
}
