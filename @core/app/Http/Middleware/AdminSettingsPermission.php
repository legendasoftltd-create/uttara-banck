<?php

namespace App\Http\Middleware;

use App\Services\AuditLogger;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminSettingsPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$param)
    {
        if (Auth::guard('admin')->check()) {
            $user_role = \App\AdminRole::where('id', auth()->guard('admin')->user()->role)->first();
            $all_permission = json_decode($user_role->permission);
            $permission = strtolower(str_replace(' ','_',$param));
            $permission_aliases = [
                'exchange_rate_manage' => 'exchange_rate',
            ];

            if (in_array($permission, $all_permission) || (isset($permission_aliases[$permission]) && in_array($permission_aliases[$permission], $all_permission))) {
                return $next($request);
            }
        }

        // checklist 3.b — record access attempts to permission-restricted areas
        AuditLogger::log('access.denied', [
            'level' => 'warning',
            'meta' => ['required_permission' => $param],
            'description' => 'Denied access to a restricted area requiring "' . $param . '" permission',
        ]);

        return redirect()->route('admin.home');
    }
}
