<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsefulLink extends Model
{
    protected $table = 'useful_links';

    protected $fillable = [
        'title',
        'url',
        'image',
        'sort_order',
        'status',
        'lang',
    ];
}
