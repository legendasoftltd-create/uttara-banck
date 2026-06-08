<?php

namespace App\Traits;

use App\Observers\AuditableObserver;

/**
 * Opt a model into automatic create/update/delete audit logging
 * (checklist item 1.e — "Capture data changes made by users").
 *
 * Usage: just `use Auditable;` on the model — no further wiring needed.
 * Add `protected $auditExcept = ['updated_at', ...];` on the model to
 * keep noisy/irrelevant attributes out of the before/after diff.
 */
trait Auditable
{
    public static function bootAuditable()
    {
        static::observe(AuditableObserver::class);
    }

    public function auditableExcept(): array
    {
        return array_merge(['updated_at', 'remember_token'], $this->auditExcept ?? []);
    }
}
