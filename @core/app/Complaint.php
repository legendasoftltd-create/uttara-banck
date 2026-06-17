<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';
    protected $fillable = [
        'concerned_division', 'concerned_branch', 'full_name', 'address', 'mobile', 'email',
        'has_account', 'account_number', 'nature_of_complain', 'amount_involved', 'details', 'suggestion', 'status',
    ];
    protected $casts = [
        'has_account' => 'boolean',
    ];
}
