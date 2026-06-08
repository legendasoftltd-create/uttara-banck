<?php

namespace App\Listeners;

use App\Services\AuditLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;

/**
 * Records authentication-related audit events (checklist 1.a/1.c/1.d):
 * login, logout, failed login attempts, registration, password resets.
 * Subscribed centrally so both the "admin" and "web" guards are covered.
 */
class AuditAuthEvents
{
    public function handleLogin(Login $event)
    {
        $user = $event->user;

        AuditLogger::log('auth.login', [
            'level' => 'info',
            'actor' => [
                'guard' => $event->guard,
                'id' => $user->getAuthIdentifier(),
                'name' => $user->name ?? $user->username ?? $user->email ?? null,
            ],
            'subject_type' => get_class($user),
            'subject_id' => $user->getAuthIdentifier(),
            'description' => 'Successful login on "' . $event->guard . '" guard',
        ]);
    }

    public function handleFailed(Failed $event)
    {
        $credentials = $event->credentials ?? [];

        AuditLogger::log('auth.login_failed', [
            'level' => 'warning',
            'meta' => [
                'guard' => $event->guard,
                'attempted_username' => $credentials['username'] ?? $credentials['email'] ?? null,
            ],
            'description' => 'Failed login attempt on "' . $event->guard . '" guard',
        ]);
    }

    public function handleLogout(Logout $event)
    {
        $user = $event->user;

        AuditLogger::log('auth.logout', [
            'level' => 'info',
            'actor' => $user ? [
                'guard' => $event->guard,
                'id' => $user->getAuthIdentifier(),
                'name' => $user->name ?? $user->username ?? $user->email ?? null,
            ] : null,
            'subject_type' => $user ? get_class($user) : null,
            'subject_id' => $user?->getAuthIdentifier(),
            'description' => 'Logout on "' . $event->guard . '" guard',
        ]);
    }

    public function handleRegistered(Registered $event)
    {
        $user = $event->user;

        AuditLogger::log('auth.registered', [
            'level' => 'info',
            'subject_type' => get_class($user),
            'subject_id' => $user->getAuthIdentifier(),
            'description' => 'New account registered: ' . ($user->email ?? $user->username ?? $user->getAuthIdentifier()),
        ]);
    }

    public function handlePasswordReset(PasswordReset $event)
    {
        $user = $event->user;

        AuditLogger::log('auth.password_reset', [
            'level' => 'warning',
            'subject_type' => get_class($user),
            'subject_id' => $user->getAuthIdentifier(),
            'description' => 'Password was reset for ' . ($user->email ?? $user->username ?? $user->getAuthIdentifier()),
        ]);
    }

    public function subscribe($events)
    {
        $events->listen(Login::class, [self::class, 'handleLogin']);
        $events->listen(Failed::class, [self::class, 'handleFailed']);
        $events->listen(Logout::class, [self::class, 'handleLogout']);
        $events->listen(Registered::class, [self::class, 'handleRegistered']);
        $events->listen(PasswordReset::class, [self::class, 'handlePasswordReset']);
    }
}
