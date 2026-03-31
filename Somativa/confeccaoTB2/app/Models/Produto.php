<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    protected $guarded = [];

    public function estoques(): HasMany
    {
        return $this->hasMany(Estoque::class);
    }
}
