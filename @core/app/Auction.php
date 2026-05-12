<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $table = 'auctions';

    protected $fillable = [
        'title',
        'slug',
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
        return $this->expiry_date->isPast();
    }
}
