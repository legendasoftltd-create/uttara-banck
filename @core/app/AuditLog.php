<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Append-only audit trail entry. Update/delete are blocked here so the
 * trail can only be appended to via AuditLogger — entries must stay immutable.
 */
class AuditLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'actor_guard',
        'actor_id',
        'actor_name',
        'action',
        'subject_type',
        'subject_id',
        'level',
        'description',
        'before',
        'after',
        'meta',
        'ip_address',
        'user_agent',
        'method',
        'url',
        'created_at',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function save(array $options = [])
    {
        if ($this->exists) {
            return false;
        }

        return parent::save($options);
    }

    public function update(array $attributes = [], array $options = [])
    {
        return false;
    }

    public function delete()
    {
        return false;
    }
}
