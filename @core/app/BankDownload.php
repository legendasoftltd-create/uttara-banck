<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDownload extends Model
{
    protected $table = 'bank_downloads';
    protected $fillable = ['title', 'slug', 'description', 'category_id', 'subcategory_id', 'files', 'publish_date', 'status', 'lang'];

    protected $casts = [
        'files' => 'array',
        'publish_date' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo('App\BankDownloadCategory', 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\BankDownloadSubcategory', 'subcategory_id');
    }
}
