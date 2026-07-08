<?php

namespace App\Http\Controllers;

class ExecutiveCommitteeController extends CommitteeMemberBaseController
{
    protected const COMMITTEE    = 'executive_committee';
    protected const TITLE        = 'Executive Committee';
    protected const ROUTE_PREFIX = 'admin.executive.committee';
}
