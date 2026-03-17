<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'document_id';
    public $incrementing = true;
    protected $fillable = [
        'vault_id',
        'folder_id',
        'name',
        'timestamps',
    ];

    public function vault()
    {
        return $this->belongsTo(Vault::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function blocks(): HasMany
    {
        // Fractional indexing (LexoRank order)
        return $this->hasMany(Block::class)->orderBy('rank', 'asc');
    }

    public function roleAssignments(): HasMany
    {
        return $this->hasMany(RoleAssignment::class);
    }
}
