<?php

namespace App\Http\Controllers;

class AuditCommitteeController extends CommitteeMemberBaseController
{
    protected const COMMITTEE    = 'audit_committee';
    protected const TITLE        = 'Audit Committee';
    protected const ROUTE_PREFIX = 'admin.audit.committee';
}
