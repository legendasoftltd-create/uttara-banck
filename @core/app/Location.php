<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'branch_point',
        'name',
        'slug',
        'type',
        'branch',
        'address',
        'district',
        'division',
        'upazila',
        'dhaka_branch',
        'latitude',
        'longitude',
        'map',
        'email',
        'phone',
        'mobile',
        'fax',
        'image',
        'opening_hours',
        'dates',
        'date_opening',
        'locker',
        'gstatus',
        'routing_no',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'dhaka_branch' => 'boolean',
        'locker' => 'boolean',
        'date_opening' => 'date',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
