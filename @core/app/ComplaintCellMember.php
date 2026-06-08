<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintCellMember extends Model
{
    protected $table = 'complaint_cell_members';
    protected $fillable = ['section', 'zone_name', 'name', 'designation', 'position', 'contact', 'sort_order'];
}
