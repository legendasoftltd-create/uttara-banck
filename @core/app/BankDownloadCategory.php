<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDownloadCategory extends Model
{
    protected $table = 'bank_download_categories';
    protected $fillable = ['title', 'slug', 'status', 'lang'];

    public function subcategories()
    {
        return $this->hasMany('App\BankDownloadSubcategory', 'category_id');
    }

    public function downloads()
    {
        return $this->hasMany('App\BankDownload', 'category_id');
    }
}
