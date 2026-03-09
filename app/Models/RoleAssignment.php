<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleAssignment extends Model
{
    use HasUuids;

    protected $fillable = [
        'account_id',
        'vault_id',
        'folder_id',
        'file_id',
        'role', // 'viewer', 'editor', 'admin'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vault(): BelongsTo
    {
        return $this->belongsTo(Vault::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function getTargetTypeAttribute(): string
    {
        if ($this->file_id !== null) {
            return 'file';
        }
        if ($this->folder_id !== null) {
            return 'folder';
        }
        return 'vault';
    }
}
