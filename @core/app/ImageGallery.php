<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    protected $table = 'image_galleries';
    protected $fillable = ['image','title','image_courtesy','publish_date','lang','cat_id'];
}
