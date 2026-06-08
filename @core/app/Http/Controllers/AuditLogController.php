<?php

namespace App\Http\Controllers;

use App\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'adminPermissionCheck:Audit Log Manage']);
    }

    public function all(Request $request)
    {
        $query = AuditLog::query()->orderBy('created_at', 'desc');

        if ($request->filled('actor_name')) {
            $query->where('actor_name', 'like', '%' . $request->actor_name . '%');
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->subject_type);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->paginate(25)->appends($request->query());

        $subject_types = AuditLog::query()
            ->whereNotNull('subject_type')
            ->distinct()
            ->orderBy('subject_type')
            ->pluck('subject_type');

        return view('backend.pages.audit-logs')->with([
            'logs' => $logs,
            'subject_types' => $subject_types,
            'filters' => $request->only(['actor_name', 'action', 'subject_type', 'level', 'start_date', 'end_date']),
        ]);
    }

    public function show($id)
    {
        $log = AuditLog::findOrFail($id);

        return response()->json([
            'status' => 'ok',
            'log' => $log,
        ]);
    }
}
