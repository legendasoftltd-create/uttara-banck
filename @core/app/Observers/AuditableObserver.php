<?php

namespace App\Observers;

use App\Services\AuditLogger;

/**
 * Generic Eloquent observer wired up via the Auditable trait. Records
 * create/update/delete with a redacted before/after diff so any model
 * can be audited just by adding `use Auditable;`.
 */
class AuditableObserver
{
    public function created($model)
    {
        AuditLogger::logModelChange('created', $model, null, $this->snapshot($model, $model->getAttributes()));
    }

    public function updated($model)
    {
        $changes = $model->getChanges();
        $except = $model->auditableExcept();
        $changes = array_diff_key($changes, array_flip($except));

        if (empty($changes)) {
            return;
        }

        $original = array_intersect_key($model->getOriginal(), $changes);

        AuditLogger::logModelChange(
            'updated',
            $model,
            $this->snapshot($model, $original),
            $this->snapshot($model, $changes)
        );
    }

    public function deleted($model)
    {
        AuditLogger::logModelChange('deleted', $model, $this->snapshot($model, $model->getAttributes()), null);
    }

    /**
     * Strip excluded attributes before persisting the diff.
     */
    protected function snapshot($model, array $attributes): array
    {
        return array_diff_key($attributes, array_flip($model->auditableExcept()));
    }
}
