<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    protected $table = 'works';
    protected $fillable = [
        'title',
        'gallery',
        'status',
        'publish_date',
        'lang',
        'categories_id',
        'slug',
        'excerpt',
        'meta_tag',
        'meta_description',
        'duration',
        'clients',
        'budget',
        'description',
        'gallery',
        'image'
    ];

    protected $casts = [
        'publish_date' => 'date'
    ];

    public function getCategoriesIdAttribute($value){
        return unserialize($value);
    }

}
