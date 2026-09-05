<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';
    protected $fillable = ['type','size','image','image_courtesy','slot','embed_code','redirect_url','click','impression','status','title'];
}
