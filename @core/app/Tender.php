<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $table = 'tenders';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file',
        'notice_date',
        'expiry_date',
        'status',
        'lang',
    ];

    protected $casts = [
        'notice_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function getFileUrlAttribute()
    {
        return $this->file ? asset('assets/uploads/tenders/' . $this->file) : null;
    }

    public function isPdf()
    {
        return $this->file && strtolower(pathinfo($this->file, PATHINFO_EXTENSION)) === 'pdf';
    }
}
