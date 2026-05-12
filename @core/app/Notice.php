<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'image',
        'notice_date',
        'expiry_date',
        'status',
        'lang',
    ];

    protected $casts = [
        'notice_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }
}
