<?php

namespace App\Http\Middleware;

use App\Services\AuditLogger;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Record unauthenticated attempts to reach protected areas
     * (checklist 3.b — access to restricted pages/APIs).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     */
    protected function unauthenticated($request, array $guards)
    {
        if ($request->is('admin-home') || $request->is('admin-home/*') || $request->is('user-home') || $request->is('user-home/*')) {
            AuditLogger::log('access.unauthenticated', [
                'level' => 'warning',
                'meta' => ['guards' => $guards],
                'description' => 'Unauthenticated access attempt to a protected area',
            ]);
        }

        parent::unauthenticated($request, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->is('admin-home') || $request->is('admin-home/*')) {
                return route('admin.login');
            }
            if ($request->is('user-home') || $request->is('user-home/*')) {
                return route('user.login');
            }
            return route('user.login');
        }
    }
}
