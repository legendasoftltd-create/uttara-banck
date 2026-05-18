<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_members';
    protected $fillable = ['name','lang','type','description','designation','image','icon_one','icon_two','icon_three','icon_one_url','icon_two_url','icon_three_url'];

    protected $casts = ['type' => 'array'];

    public static function types()
    {
        return [
            'board_of_directors'        => 'Board of Directors',
            'executive_committee'       => 'Executive Committee',
            'audit_committee'           => 'Audit Committee',
            'risk_management_committee' => 'Risk Management Committee',
            'senior_management'         => 'Senior Management',
        ];
    }

    public static function slugMap()
    {
        return [
            'board-of-director'         => 'board_of_directors',
            'executive-committee'       => 'executive_committee',
            'audit-committee'           => 'audit_committee',
            'risk-management-committee' => 'risk_management_committee',
            'senior-management'         => 'senior_management',
        ];
    }
}
