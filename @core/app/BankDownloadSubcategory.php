<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDownloadSubcategory extends Model
{
    protected $table = 'bank_download_subcategories';
    protected $fillable = ['title', 'slug', 'category_id', 'status', 'lang'];

    public function category()
    {
        return $this->belongsTo('App\BankDownloadCategory', 'category_id');
    }

    public function downloads()
    {
        return $this->hasMany('App\BankDownload', 'subcategory_id');
    }
}
