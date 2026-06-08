<?php

namespace App\Services;

use App\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use Throwable;

/**
 * Single entry point for writing to the audit trail.
 *
 * Captures who/what/when/where/how on every call so callers only need to
 * supply the action name and (optionally) the subject + before/after state.
 * Sensitive keys are redacted before anything is persisted.
 */
class AuditLogger
{
    /**
     * Attribute keys whose values are masked wherever they appear in
     * before/after/meta payloads (passwords, tokens, secrets, PII, etc.).
     */
    protected static array $redactedKeys = [
        'password',
        'password_confirmation',
        'current_password',
        'token',
        'remember_token',
        'access_token',
        'refresh_token',
        'secret',
        'api_key',
        'api_secret',
        'client_secret',
        'private_key',
        'authorization',
        'card_number',
        'cvv',
        'otp',
    ];

    const REDACTED_VALUE = '***redacted***';

    public static function log(string $action, array $options = []): ?AuditLog
    {
        try {
            $request = RequestFacade::instance();
            $actor = static::resolveActor($options['actor'] ?? null);

            return AuditLog::create([
                'actor_guard' => $actor['guard'],
                'actor_id' => $actor['id'],
                'actor_name' => $actor['name'],
                'action' => $action,
                'subject_type' => $options['subject_type'] ?? null,
                'subject_id' => $options['subject_id'] ?? null,
                'level' => $options['level'] ?? 'info',
                'description' => $options['description'] ?? null,
                'before' => static::redact($options['before'] ?? null),
                'after' => static::redact($options['after'] ?? null),
                'meta' => static::redact($options['meta'] ?? null),
                'ip_address' => $request?->ip(),
                'user_agent' => $request?->userAgent(),
                'method' => $request?->method(),
                'url' => $request?->fullUrl(),
                'created_at' => now(),
            ]);
        } catch (Throwable $e) {
            // Auditing must never break the calling flow.
            report($e);

            return null;
        }
    }

    /**
     * Convenience wrapper for recording a model's create/update/delete.
     */
    public static function logModelChange(string $action, $model, ?array $before = null, ?array $after = null): ?AuditLog
    {
        return static::log($action, [
            'subject_type' => get_class($model),
            'subject_id' => $model->getKey(),
            'before' => $before,
            'after' => $after,
            'description' => $action . ' ' . class_basename($model) . ' #' . $model->getKey(),
        ]);
    }

    /**
     * Resolve the acting identity. Falls back to whichever guard
     * (admin/web) currently has an authenticated user.
     */
    protected static function resolveActor(?array $actor): array
    {
        if ($actor) {
            return array_merge(['guard' => null, 'id' => null, 'name' => null], $actor);
        }

        foreach (['admin', 'web'] as $guard) {
            $user = Auth::guard($guard)->user();
            if ($user) {
                return [
                    'guard' => $guard,
                    'id' => $user->getAuthIdentifier(),
                    'name' => $user->name ?? $user->username ?? $user->email ?? null,
                ];
            }
        }

        return ['guard' => null, 'id' => null, 'name' => null];
    }

    /**
     * Recursively mask sensitive values so they never reach storage.
     */
    public static function redact($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $redacted = [];
        foreach ($data as $key => $value) {
            if (is_string($key) && in_array(strtolower($key), static::$redactedKeys, true)) {
                $redacted[$key] = static::REDACTED_VALUE;
            } elseif (is_array($value)) {
                $redacted[$key] = static::redact($value);
            } else {
                $redacted[$key] = $value;
            }
        }

        return $redacted;
    }
}
