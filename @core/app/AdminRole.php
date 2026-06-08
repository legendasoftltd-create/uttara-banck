<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class AdminRole extends Model
{
    use Auditable;

    protected $table = 'admin_roles';
    protected $fillable = ['name' ,'permission'];

}
