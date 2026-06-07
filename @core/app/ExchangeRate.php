<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = ['items', 'pdf', 'status'];

    protected $casts = [
        'items' => 'array',
    ];
}
